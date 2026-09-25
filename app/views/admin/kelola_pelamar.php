<!-- Custom Style BKK DOSQLA -->
<style>
    :root {
        --bkk-navy-dark: #0D1033;
        --bkk-navy-blue: #0F4C81;
        --bkk-sky-blue: #71C9CE;
        --bkk-orange: #F2994A;
    }

    /* Secondary / Outline Button Style */
    .btn-bkk-outline {
        border: 1px solid var(--bkk-navy-blue);
        color: var(--bkk-navy-blue);
        background-color: transparent;
        transition: all 0.2s ease-in-out;
    }
    .btn-bkk-outline:hover {
        background-color: var(--bkk-navy-blue);
        color: #ffffff;
    }

    /* Custom Form Select Focus */
    .form-select:focus {
        border-color: var(--bkk-navy-blue) !important;
        box-shadow: 0 0 0 3px rgba(15, 76, 129, 0.15) !important;
    }
</style>

<div class="container-fluid px-4 py-6">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 mb-6 border-b border-slate-200 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-[#0D1033] tracking-tight">Kelola Pelamar & Lamaran</h1>
            <p class="text-sm text-slate-500 mt-1">Verifikasi berkas CV, unduh dokumen, dan ubah status seleksi pelamar kerja.</p>
        </div>
        <div>
            <a href="<?= BASE_URL ?>admin" class="btn-bkk-outline rounded-xl text-sm px-4 py-2 font-bold inline-flex items-center gap-2">
                <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Alert Flash Message -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-xl mb-4 shadow-sm border-0 bg-emerald-50 text-emerald-800" role="alert">
            <i class="fa-solid fa-circle-check mr-2 text-emerald-600"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-xl mb-4 shadow-sm border-0 bg-rose-50 text-rose-800" role="alert">
            <i class="fa-solid fa-triangle-exclamation mr-2 text-rose-600"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Card Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
        <div class="table-responsive">
            <table id="tablePelamar" class="table table-hover align-middle w-full border-collapse">
                <thead>
                    <tr class="bg-[#0D1033] text-white text-xs font-semibold uppercase tracking-wider">
                        <th class="w-12 text-center py-3.5">No</th>
                        <th class="py-3.5">Pelamar</th>
                        <th class="py-3.5">Lowongan Kerja</th>
                        <th class="text-center py-3.5">Tanggal Melamar</th>
                        <th class="text-center py-3.5">Berkas CV</th>
                        <th class="text-center py-3.5">Status Saat Ini</th>
                        <th class="text-center py-3.5">Aksi / Ubah Status</th>
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
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="text-center font-bold text-slate-400 text-xs"><?= $no++; ?></td>
                                <td>
                                    <div class="font-bold text-[#0D1033]"><?= $nama; ?></div>
                                    <div class="text-xs text-slate-500 font-medium"><?= $email; ?></div>
                                </td>
                                <td>
                                    <span class="inline-flex items-center gap-1.5 bg-sky-50 text-[#0F4C81] border border-sky-200/80 px-3 py-1 rounded-lg font-bold text-xs">
                                        <i class="fa-solid fa-briefcase text-xs text-[#71C9CE]"></i> <?= $jobTitle; ?>
                                    </span>
                                </td>
                                <td class="text-center text-xs text-slate-500 font-medium">
                                    <i class="fa-regular fa-calendar-check mr-1 text-slate-400"></i><?= $tglMelamar; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($fileCv)): ?>
                                        <a href="<?= BASE_URL ?>public/uploads/<?= htmlspecialchars($fileCv); ?>" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg font-bold text-xs transition border border-rose-100 shadow-sm">
                                            <i class="fa-solid fa-file-pdf"></i> Lihat / Download
                                        </a>
                                    <?php else: ?>
                                        <span class="text-xs text-slate-400 italic font-medium">Belum Mengunggah</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($status === 'lolos'): ?>
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Lolos
                                        </span>
                                    <?php elseif ($status === 'tidak_lolos' || $status === 'tidak lolos'): ?>
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Tidak Lolos
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Proses
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <form action="<?= BASE_URL ?>admin/update-status-pelamar" method="POST" class="d-inline-flex items-center justify-center gap-2">
                                        <input type="hidden" name="id_lamaran" value="<?= $idLamaran; ?>">
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm rounded-xl border-slate-300 text-xs font-semibold shadow-sm text-slate-700 cursor-pointer py-1.5">
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