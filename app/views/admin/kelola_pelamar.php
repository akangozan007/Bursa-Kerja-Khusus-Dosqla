<div class="container-fluid px-4 py-6">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 mb-6 border-b border-slate-200 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Kelola Pelamar & Lamaran</h1>
            <p class="text-sm text-slate-500 mt-1">Verifikasi berkas CV, unduh dokumen, dan ubah status seleksi pelamar kerja.</p>
        </div>
        <div>
            <a href="<?= BASE_URL ?>admin" class="btn btn-outline-secondary rounded-xl text-sm px-4 py-2 inline-flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Alert Flash Message -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-xl mb-4 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check mr-2"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-xl mb-4 shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Card Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
        <div class="table-responsive">
            <table id="tablePelamar" class="table table-hover align-middle w-full">
                <thead class="bg-slate-50 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="w-12 text-center py-3">No</th>
                        <th>Pelamar</th>
                        <th>Lowongan Kerja</th>
                        <th class="text-center">Tanggal Melamar</th>
                        <th class="text-center">Berkas CV</th>
                        <th class="text-center">Status Saat Ini</th>
                        <th class="text-center">Aksi / Ubah Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    <?php if (!empty($applicants)): ?>
                        <?php $no = 1; foreach ($applicants as $row): ?>
                            <?php 
                                $idLamaran = $row['id_lamaran'] ?? $row['id'] ?? 0;
                                $nama       = htmlspecialchars($row['nama_lengkap'] ?? $row['username'] ?? 'Pelamar');
                                $email      = htmlspecialchars($row['email'] ?? '-');
                                $jobTitle   = htmlspecialchars($row['judul_lowongan'] ?? $row['title'] ?? 'Lowongan');
                                $tglMelamar = !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-';
                                $fileCv     = $row['file_cv'] ?? $row['cv_file'] ?? '';
                                $status     = strtolower($row['status'] ?? 'proses');
                            ?>
                            <tr>
                                <td class="text-center font-medium text-slate-400"><?= $no++; ?></td>
                                <td>
                                    <div class="font-semibold text-slate-800"><?= $nama; ?></div>
                                    <div class="text-xs text-slate-400"><?= $email; ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1.5 rounded-lg font-medium">
                                        <?= $jobTitle; ?>
                                    </span>
                                </td>
                                <td class="text-center text-xs text-slate-500">
                                    <?= $tglMelamar; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($fileCv)): ?>
                                        <a href="<?= BASE_URL ?>public/uploads/<?= htmlspecialchars($fileCv); ?>" target="_blank" class="btn btn-sm btn-outline-danger rounded-lg px-3 inline-flex items-center gap-1.5 text-xs">
                                            <i class="fa-solid fa-file-pdf"></i> Lihat / Download
                                        </a>
                                    <?php else: ?>
                                        <span class="text-xs text-slate-400 italic">Belum Mengunggah</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($status === 'lolos'): ?>
                                        <span class="badge bg-emerald-100 text-emerald-800 border border-emerald-300 px-3 py-1.5 rounded-lg">Lolos</span>
                                    <?php elseif ($status === 'tidak_lolos' || $status === 'tidak lolos'): ?>
                                        <span class="badge bg-rose-100 text-rose-800 border border-rose-300 px-3 py-1.5 rounded-lg">Tidak Lolos</span>
                                    <?php else: ?>
                                        <span class="badge bg-amber-100 text-amber-800 border border-amber-300 px-3 py-1.5 rounded-lg">Proses</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <form action="<?= BASE_URL ?>admin/update-status-pelamar" method="POST" class="d-inline-flex items-center gap-2">
                                        <input type="hidden" name="id_lamaran" value="<?= $idLamaran; ?>">
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm rounded-lg border-slate-300 text-xs shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="proses" <?= $status === 'proses' ? 'selected' : ''; ?>>Proses</option>
                                            <option value="lolos" <?= $status === 'lolos' ? 'selected' : ''; ?>>Lolos</option>
                                            <option value="tidak_lolos" <?= ($status === 'tidak_lolos' || $status === 'tidak lolos') ? 'selected' : ''; ?>>Tidak Lolos</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Inisialisasi DataTables Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof $ !== 'undefined' && $.fn.DataTable) {
            $('#tablePelamar').DataTable({
                responsive: true,
                language: {
                    search: "Cari Pelamar:",
                    lengthMenu: "Tampilkan _MENU_ baris",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ pelamar",
                    zeroRecords: "Data pelamar tidak ditemukan",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Lanjut",
                        previous: "Kembali"
                    }
                }
            });
        }
    });
</script>