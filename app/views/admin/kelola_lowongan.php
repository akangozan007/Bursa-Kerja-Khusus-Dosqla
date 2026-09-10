<div class="container-fluid px-4 py-6">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 mb-6 border-b border-slate-200 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Kelola Lowongan Kerja</h1>
            <p class="text-sm text-slate-500 mt-1">Tambah, ubah, dan hapus data lowongan pekerjaan BKK DOSQLA.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="openJobModal()" class="btn btn-primary rounded-xl text-sm px-4 py-2 inline-flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-plus"></i> Tambah Lowongan Baru
            </button>
            <a href="<?= BASE_URL ?>admin" class="btn btn-outline-secondary rounded-xl text-sm px-4 py-2 inline-flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Card Table Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
        <div class="table-responsive">
            <table id="tableLowongan" class="table table-hover align-middle w-full">
                <thead class="bg-slate-50 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="w-12 text-center py-3">No</th>
                        <th>Posisi / Judul Lowongan</th>
                        <th>Perusahaan</th>
                        <th>Tanggal Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    <?php if (!empty($jobs)): ?>
                        <?php $no = 1; foreach ($jobs as $j): ?>
                            <?php 
                                $id         = $j['id'];
                                $judul      = htmlspecialchars($j['judul'] ?? '-');
                                $perusahaan = htmlspecialchars($j['perusahaan'] ?? '-');
                                $deskripsi  = htmlspecialchars($j['deskripsi'] ?? '');
                                $created_at = !empty($j['created_at']) ? date('d M Y H:i', strtotime($j['created_at'])) : '-';
                            ?>
                            <tr>
                                <td class="text-center font-medium text-slate-400"><?= $no++; ?></td>
                                <td>
                                    <div class="font-semibold text-slate-800"><?= $judul; ?></div>
                                    <div class="text-xs text-slate-500 line-clamp-1 mt-0.5"><?= $deskripsi; ?></div>
                                </td>
                                <td class="font-medium text-slate-700">
                                    <i class="fa-solid fa-building text-slate-400 mr-1.5"></i><?= $perusahaan; ?>
                                </td>
                                <td class="text-xs text-slate-500">
                                    <?= $created_at; ?>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit Button -->
                                        <button onclick="editJob(<?= htmlspecialchars(json_encode([
                                            'id'         => $id,
                                            'judul'      => $j['judul'] ?? '',
                                            'perusahaan' => $j['perusahaan'] ?? '',
                                            'deskripsi'  => $j['deskripsi'] ?? ''
                                        ]), ENT_QUOTES, 'UTF-8'); ?>)" class="btn btn-sm btn-outline-primary rounded-lg text-xs px-3">
                                            <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <button onclick="deleteJob(<?= $id; ?>)" class="btn btn-sm btn-outline-danger rounded-lg text-xs px-3">
                                            <i class="fa-solid fa-trash mr-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Tambah / Edit Lowongan -->
<div class="modal fade" id="jobModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-lg">
            <div class="modal-header border-b border-slate-100 px-6 py-4">
                <h5 class="modal-title font-bold text-slate-800 text-lg" id="jobModalTitle">Tambah Lowongan Pekerjaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="jobForm">
                <div class="modal-body p-6 space-y-4">
                    <input type="hidden" id="job_id" name="id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label text-xs font-semibold text-slate-600 uppercase">Judul Posisi <span class="text-rose-500">*</span></label>
                            <input type="text" name="judul" id="job_judul" class="form-control rounded-xl text-sm" placeholder="Contoh: Web Developer (Fullstack)" required>
                        </div>
                        <div>
                            <label class="form-label text-xs font-semibold text-slate-600 uppercase">Nama Perusahaan <span class="text-rose-500">*</span></label>
                            <input type="text" name="perusahaan" id="job_perusahaan" class="form-control rounded-xl text-sm" placeholder="Contoh: PT Teknologi Nusantara" required>
                        </div>
                    </div>

                    <div>
                        <label class="form-label text-xs font-semibold text-slate-600 uppercase">Deskripsi Pekerjaan & Kualifikasi</label>
                        <textarea name="deskripsi" id="job_deskripsi" rows="4" class="form-control rounded-xl text-sm" placeholder="Tulis rincian tugas dan persyaratan pelamar..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-t border-slate-100 px-6 py-4">
                    <button type="button" class="btn btn-light rounded-xl text-sm px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-xl text-sm px-5 inline-flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- AJAX Script CRUD Lowongan -->
<script>
    let bsModal;

    document.addEventListener("DOMContentLoaded", function() {
        bsModal = new bootstrap.Modal(document.getElementById('jobModal'));

        if (typeof $ !== 'undefined' && $.fn.DataTable) {
            $('#tableLowongan').DataTable({
                responsive: true,
                language: {
                    search: "Cari Lowongan:",
                    lengthMenu: "Tampilkan _MENU_ baris",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ lowongan",
                    zeroRecords: "Data lowongan tidak ditemukan",
                    paginate: { first: "Awal", last: "Akhir", next: "Lanjut", previous: "Kembali" }
                }
            });
        }

        // Submit Form via AJAX
        $('#jobForm').on('submit', function(e) {
            e.preventDefault();
            $.post('<?= BASE_URL ?>admin/save-job', $(this).serialize(), function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message || 'Gagal menyimpan data lowongan.');
                }
            }, 'json').fail(function() {
                alert('Terjadi kesalahan pada server.');
            });
        });
    });

    function openJobModal() {
        $('#jobForm')[0].reset();
        $('#job_id').val('');
        $('#jobModalTitle').text('Tambah Lowongan Pekerjaan');
        bsModal.show();
    }

    function editJob(data) {
        $('#job_id').val(data.id);
        $('#job_judul').val(data.judul);
        $('#job_perusahaan').val(data.perusahaan);
        $('#job_deskripsi').val(data.deskripsi);

        $('#jobModalTitle').text('Edit Lowongan Pekerjaan');
        bsModal.show();
    }

    function deleteJob(jobId) {
        if (confirm('Apakah Anda yakin ingin menghapus lowongan ini? Data yang terhapus tidak dapat dikembalikan.')) {
            $.post('<?= BASE_URL ?>admin/delete-job', { id: jobId }, function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message || 'Gagal menghapus lowongan.');
                }
            }, 'json').fail(function() {
                alert('Terjadi kesalahan pada server.');
            });
        }
    }
</script>