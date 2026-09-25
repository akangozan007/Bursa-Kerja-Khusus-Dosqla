<!-- Custom Style BKK DOSQLA -->
<style>
    :root {
        --bkk-navy-dark: #0D1033;
        --bkk-navy-blue: #0F4C81;
        --bkk-sky-blue: #71C9CE;
        --bkk-orange: #F2994A;
    }

    /* Primary Button Style */
    .btn-bkk-primary {
        background-color: var(--bkk-orange);
        color: #ffffff;
        border: none;
        transition: all 0.2s ease-in-out;
    }
    .btn-bkk-primary:hover {
        background-color: #e08332;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(242, 153, 74, 0.3);
    }

    /* Secondary / Outline Style */
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

    /* Custom Input Focus State */
    .form-control:focus {
        border-color: var(--bkk-navy-blue) !important;
        box-shadow: 0 0 0 3px rgba(15, 76, 129, 0.15) !important;
    }
</style>

<div class="container-fluid px-4 py-6">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 mb-6 border-b border-slate-200 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-[#0D1033] tracking-tight">Kelola Lowongan Kerja</h1>
            <p class="text-sm text-slate-500 mt-1">Tambah, ubah, dan hapus data lowongan pekerjaan BKK DOSQLA.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="openJobModal()" class="btn-bkk-primary rounded-xl text-sm px-4 py-2 font-bold inline-flex items-center gap-2 shadow-sm cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Lowongan Baru
            </button>
            <a href="<?= BASE_URL ?>admin" class="btn-bkk-outline rounded-xl text-sm px-4 py-2 font-bold inline-flex items-center gap-2">
                <i class="fa-solid fa-arrow-left text-xs"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Card Table Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
        <div class="table-responsive">
            <table id="tableLowongan" class="table table-hover align-middle w-full border-collapse">
                <thead>
                    <tr class="bg-[#0D1033] text-white text-xs font-semibold uppercase tracking-wider">
                        <th class="w-12 text-center py-3.5">No</th>
                        <th class="py-3.5">Posisi / Judul Lowongan</th>
                        <th class="py-3.5">Perusahaan</th>
                        <th class="py-3.5">Tanggal Dibuat</th>
                        <th class="text-center py-3.5">Aksi</th>
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
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="text-center font-bold text-slate-400 text-xs"><?= $no++; ?></td>
                                <td>
                                    <div class="font-bold text-[#0D1033]"><?= $judul; ?></div>
                                    <div class="text-xs text-slate-500 line-clamp-1 mt-0.5"><?= $deskripsi; ?></div>
                                </td>
                                <td class="font-semibold text-slate-700">
                                    <div class="inline-flex items-center gap-1.5">
                                        <i class="fa-solid fa-building text-slate-400 text-xs"></i>
                                        <span><?= $perusahaan; ?></span>
                                    </div>
                                </td>
                                <td class="text-xs text-slate-500 font-medium">
                                    <i class="fa-regular fa-clock mr-1 text-slate-400"></i><?= $created_at; ?>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit Button -->
                                        <button onclick="editJob(<?= htmlspecialchars(json_encode([
                                            'id'         => $id,
                                            'judul'      => $j['judul'] ?? '',
                                            'perusahaan' => $j['perusahaan'] ?? '',
                                            'deskripsi'  => $j['deskripsi'] ?? ''
                                        ]), ENT_QUOTES, 'UTF-8'); ?>)" class="inline-flex items-center gap-1 px-3 py-1.5 bg-sky-50 text-[#0F4C81] hover:bg-[#0F4C81] hover:text-white rounded-lg font-bold text-xs transition border border-sky-100 cursor-pointer">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <button onclick="deleteJob(<?= $id; ?>)" class="inline-flex items-center gap-1 px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg font-bold text-xs transition border border-rose-100 cursor-pointer">
                                            <i class="fa-solid fa-trash"></i> Hapus
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
        <div class="modal-content rounded-2xl border-0 shadow-xl overflow-hidden">
            <div class="modal-header bg-slate-50 border-b border-slate-100 px-6 py-4">
                <h5 class="modal-title font-extrabold text-[#0D1033] text-lg" id="jobModalTitle">Tambah Lowongan Pekerjaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="jobForm">
                <div class="modal-body p-6 space-y-4">
                    <input type="hidden" id="job_id" name="id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label text-xs font-bold text-slate-600 uppercase tracking-wider">Judul Posisi <span class="text-rose-500">*</span></label>
                            <input type="text" name="judul" id="job_judul" class="form-control rounded-xl text-sm py-2.5" placeholder="Contoh: Web Developer (Fullstack)" required>
                        </div>
                        <div>
                            <label class="form-label text-xs font-bold text-slate-600 uppercase tracking-wider">Nama Perusahaan <span class="text-rose-500">*</span></label>
                            <input type="text" name="perusahaan" id="job_perusahaan" class="form-control rounded-xl text-sm py-2.5" placeholder="Contoh: PT Teknologi Nusantara" required>
                        </div>
                    </div>

                    <div>
                        <label class="form-label text-xs font-bold text-slate-600 uppercase tracking-wider">Deskripsi Pekerjaan & Kualifikasi</label>
                        <textarea name="deskripsi" id="job_deskripsi" rows="4" class="form-control rounded-xl text-sm py-2.5" placeholder="Tulis rincian tugas dan persyaratan pelamar..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-t border-slate-100 px-6 py-4 bg-slate-50/50">
                    <button type="button" class="btn btn-light rounded-xl text-xs font-bold px-4 py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-bkk-primary rounded-xl text-xs font-bold px-5 py-2 inline-flex items-center gap-2 cursor-pointer">
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