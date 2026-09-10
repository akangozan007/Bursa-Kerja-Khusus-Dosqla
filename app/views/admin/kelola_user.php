<div class="container-fluid px-4 py-6">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 mb-6 border-b border-slate-200 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Kelola User & Akun</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola hak akses pengguna, status blokir akun, dan reset password user.</p>
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
            <table id="tableUser" class="table table-hover align-middle w-full">
                <thead class="bg-slate-50 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="w-12 text-center py-3">No</th>
                        <th>Pengguna</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Status Akses</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    <?php if (!empty($users)): ?>
                        <?php $no = 1; foreach ($users as $u): ?>
                            <?php 
                                $userId   = $u['id'];
                                $username = htmlspecialchars($u['username'] ?? '-');
                                $email    = htmlspecialchars($u['email'] ?? '-');
                                $roleUser = strtolower($u['role'] ?? 'pelamar');
                                $status   = strtolower($u['status'] ?? 'active');
                            ?>
                            <tr>
                                <td class="text-center font-medium text-slate-400"><?= $no++; ?></td>
                                <td>
                                    <div class="font-semibold text-slate-800"><?= $username; ?></div>
                                    <div class="text-xs text-slate-400"><?= $email; ?></div>
                                </td>
                                <td class="text-center">
                                    <?php if ($roleUser === 'admin'): ?>
                                        <span class="badge bg-purple-100 text-purple-800 border border-purple-300 px-3 py-1.5 rounded-lg">Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-blue-100 text-blue-800 border border-blue-300 px-3 py-1.5 rounded-lg">Pelamar</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($status === 'active'): ?>
                                        <span class="badge bg-emerald-100 text-emerald-800 border border-emerald-300 px-3 py-1.5 rounded-lg">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-rose-100 text-rose-800 border border-rose-300 px-3 py-1.5 rounded-lg">Diblokir</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Button Toggle Status (Aktif / Blokir) -->
                                        <button onclick="toggleUserStatus(<?= $userId; ?>, '<?= $status === 'active' ? 'blocked' : 'active'; ?>')" 
                                                class="btn btn-sm <?= $status === 'active' ? 'btn-outline-danger' : 'btn-outline-success'; ?> rounded-lg text-xs px-3">
                                            <i class="fa-solid <?= $status === 'active' ? 'fa-user-slash' : 'fa-user-check'; ?> mr-1"></i>
                                            <?= $status === 'active' ? 'Blokir' : 'Aktifkan'; ?>
                                        </button>

                                        <!-- Button Reset Password -->
                                        <button onclick="resetUserPassword(<?= $userId; ?>)" 
                                                class="btn btn-sm btn-outline-warning rounded-lg text-xs px-3">
                                            <i class="fa-solid fa-key mr-1"></i> Reset Pass
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
        if (typeof $ !== 'undefined' && $.fn.DataTable) {
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