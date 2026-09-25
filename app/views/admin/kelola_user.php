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
</style>

<div class="container-fluid px-4 py-6">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 mb-6 border-b border-slate-200 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-[#0D1033] tracking-tight">Kelola User & Akun</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola hak akses pengguna, status blokir akun, dan reset password user.</p>
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
            <table id="tableUser" class="table table-hover align-middle w-full border-collapse">
                <thead>
                    <tr class="bg-[#0D1033] text-white text-xs font-semibold uppercase tracking-wider">
                        <th class="w-12 text-center py-3.5">No</th>
                        <th class="py-3.5">Pengguna</th>
                        <th class="text-center py-3.5">Role</th>
                        <th class="text-center py-3.5">Status Akses</th>
                        <th class="text-center py-3.5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    <?php if (!empty($users)): ?>
                        <?php $no = 1; foreach ($users as$u): ?>
                            <?php 
                                $userId   =$u['id'];
                                $username = htmlspecialchars($u['username'] ?? '-');
                                $email    = htmlspecialchars($u['email'] ?? '-');
                                $roleUser = strtolower($u['role'] ?? 'pelamar');
                                $status   = strtolower($u['status'] ?? 'active');
                            ?>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="text-center font-bold text-slate-400 text-xs"><?= $no++; ?></td>
                                <td>
                                    <div class="font-bold text-[#0D1033]"><?= $username; ?></div>
                                    <div class="text-xs text-slate-500 font-medium"><?= $email; ?></div>
                                </td>
                                <td class="text-center">
                                    <?php if ($roleUser === 'admin'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/80">
                                            <i class="fa-solid fa-user-shield text-xs"></i> Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-sky-50 text-[#0F4C81] border border-sky-200/80">
                                            <i class="fa-solid fa-user text-xs text-[#71C9CE]"></i> Pelamar
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($status === 'active'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Diblokir
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Button Toggle Status (Aktif / Blokir) -->
                                        <?php if ($status === 'active'): ?>
                                            <button onclick="toggleUserStatus(<?= $userId; ?>, 'blocked')" 
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg font-bold text-xs transition border border-rose-100 cursor-pointer shadow-sm">
                                                <i class="fa-solid fa-user-slash"></i> Blokir
                                            </button>
                                        <?php else: ?>
                                            <button onclick="toggleUserStatus(<?= $userId; ?>, 'active')" 
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-lg font-bold text-xs transition border border-emerald-100 cursor-pointer shadow-sm">
                                                <i class="fa-solid fa-user-check"></i> Aktifkan
                                            </button>
                                        <?php endif; ?>

                                        <!-- Button Reset Password -->
                                        <button onclick="resetUserPassword(<?= $userId; ?>)" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-500 hover:text-white rounded-lg font-bold text-xs transition border border-amber-200/80 cursor-pointer shadow-sm">
                                            <i class="fa-solid fa-key"></i> Reset Pass
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

<!-- AJAX Script Toggle Status & Reset Password -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof $!== 'undefined' &&$.fn.DataTable) {
            $('#tableUser').DataTable({
                responsive: true,
                language: {
                    search: "Cari User:",
                    lengthMenu: "Tampilkan _MENU_ baris",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ user",
                    zeroRecords: "Data user tidak ditemukan",
                    paginate: { first: "Awal", last: "Akhir", next: "Lanjut", previous: "Kembali" }
                }
            });
        }
    });

    function toggleUserStatus(userId, newStatus) {
        const actionText = newStatus === 'blocked' ? 'memblokir' : 'mengaktifkan kembali';
        if (confirm(`Apakah Anda yakin ingin ${actionText} akun ini?`)) {
            $.post('<?= BASE_URL ?>admin/toggle-user-status', { id: userId, status: newStatus }, function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message || 'Gagal memperbarui status user.');
                }
            }, 'json').fail(function() {
                alert('Terjadi kesalahan pada server.');
            });
        }
    }

    function resetUserPassword(userId) {
        if (confirm('Apakah Anda yakin ingin mereset password akun ini ke default (12345678)?')) {
            $.post('<?= BASE_URL ?>admin/reset-user-password', { id: userId }, function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                } else {
                    alert(response.message || 'Gagal mereset password.');
                }
            }, 'json').fail(function() {
                alert('Terjadi kesalahan pada server.');
            });
        }
    }
</script>