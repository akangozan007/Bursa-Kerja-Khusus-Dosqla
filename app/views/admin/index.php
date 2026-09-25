<!-- Custom Style Variable BKK DOSQLA -->
<style>
    :root {
        --bkk-navy-dark: #0D1033;
        --bkk-navy-blue: #0F4C81;
        --bkk-sky-blue: #71C9CE;
        --bkk-orange: #F2994A;
    }

    .btn-bkk-primary {
        background-color: var(--bkk-orange);
        color: #ffffff;
        transition: all 0.2s ease-in-out;
    }
    .btn-bkk-primary:hover {
        background-color: #e08332;
        box-shadow: 0 4px 12px rgba(242, 153, 74, 0.3);
    }
</style>

<!-- TAB 1: DASHBOARD MINI -->
<div id="tab-dashboard" class="tab-content space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
        <!-- Lowongan Aktif -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Lowongan Aktif</p>
                <p class="text-2xl font-extrabold text-[#0D1033] mt-1"><?= $stats['total_jobs'] ?? 0 ?></p>
            </div>
            <div class="w-11 h-11 bg-cyan-50 text-[#71C9CE] rounded-xl flex items-center justify-center text-lg border border-cyan-100">
                <i class="fa-solid fa-briefcase"></i>
            </div>
        </div>

        <!-- Total Pelamar -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Pelamar</p>
                <p class="text-2xl font-extrabold text-[#0F4C81] mt-1"><?= $stats['total_applicants'] ?? 0 ?></p>
            </div>
            <div class="w-11 h-11 bg-sky-50 text-[#0F4C81] rounded-xl flex items-center justify-center text-lg border border-sky-100">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
        </div>

        <!-- Alumni Diterima -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Alumni Diterima</p>
                <p class="text-2xl font-extrabold text-emerald-600 mt-1"><?= $stats['total_hired'] ?? 0 ?></p>
            </div>
            <div class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg border border-emerald-100">
                <i class="fa-solid fa-user-check"></i>
            </div>
        </div>

        <!-- Total User Registered -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">User Terdaftar</p>
                <p class="text-2xl font-extrabold text-[#F2994A] mt-1"><?= $stats['total_users'] ?? 0 ?></p>
            </div>
            <div class="w-11 h-11 bg-amber-50 text-[#F2994A] rounded-xl flex items-center justify-center text-lg border border-amber-100">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>
</div>

<!-- TAB 2: MANAJEMEN LOWONGAN (CRUD) -->
<div id="tab-jobs" class="tab-content hidden space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80">
        <div>
            <h2 class="text-base font-extrabold text-[#0D1033]">Daftar Lowongan Pekerjaan</h2>
            <p class="text-xs text-slate-400 mt-0.5">Kelola data seluruh lowongan kerja BKK DOSQLA.</p>
        </div>
        <button onclick="openJobModal()" class="btn-bkk-primary px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-2 self-start sm:self-auto cursor-pointer">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Lowongan
        </button>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0D1033] text-white text-[11px] uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-6">Posisi / Perusahaan</th>
                        <th class="py-3.5 px-6">Tgl Buka - Tutup</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs sm:text-sm text-slate-700">
                    <?php if (!empty($jobs)): ?>
                        <?php foreach ($jobs as $job): ?>
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <div class="font-bold text-[#0D1033]"><?= htmlspecialchars($job['title']) ?></div>
                                <div class="text-xs text-slate-500 font-medium inline-flex items-center gap-1 mt-0.5">
                                    <i class="fa-solid fa-building text-slate-400"></i> <?= htmlspecialchars($job['company']) ?>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-500 font-medium text-xs">
                                <i class="fa-regular fa-calendar-check mr-1 text-slate-400"></i> <?= $job['open_date'] ?> <span class="text-slate-300">s/d</span> <?= $job['close_date'] ?>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1 px-3 py-1 text-[11px] font-bold rounded-full border <?= $job['status'] === 'open' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200' ?>">
                                    <i class="fa-solid fa-circle text-[6px]"></i> <?= strtoupper($job['status']) ?>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button onclick="deleteJob(<?= $job['id'] ?>)" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg font-bold text-xs transition border border-rose-100 cursor-pointer" title="Hapus Lowongan">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-10 text-slate-400 text-xs">
                                <i class="fa-solid fa-inbox text-2xl mb-2 text-slate-300 block"></i>
                                Belum ada data lowongan pekerjaan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TAB 3: MANAJEMEN PELAMAR -->
<div id="tab-applicants" class="tab-content hidden space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h2 class="font-extrabold text-[#0D1033] text-base">Manajemen Pelamar Kerja</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0D1033] text-white text-[11px] uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-6">Nama Pelamar</th>
                        <th class="py-3.5 px-6">Lowongan</th>
                        <th class="py-3.5 px-6">Berkas CV</th>
                        <th class="py-3.5 px-6">Status Lamaran</th>
                        <th class="py-3.5 px-6">Tgl Apply</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs sm:text-sm text-slate-700">
                    <?php if (!empty($applicants)): ?>
                        <?php foreach ($applicants as $app): ?>
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <div class="font-bold text-[#0D1033]"><?= htmlspecialchars($app['name']) ?></div>
                                <div class="text-xs text-slate-400 font-medium"><?= htmlspecialchars($app['email']) ?></div>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-700"><?= htmlspecialchars($app['job_title']) ?></td>
                            <td class="py-4 px-6">
                                <a href="<?= BASE_URL ?>public/uploads/<?= $app['cv_file'] ?>" target="_blank" class="inline-flex items-center gap-1.5 text-[#0F4C81] hover:underline font-bold text-xs bg-sky-50 px-2.5 py-1 rounded-md border border-sky-100">
                                    <i class="fa-solid fa-file-pdf text-rose-500"></i> Lihat CV
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                <select onchange="updateApplicantStatus(<?= $app['app_id'] ?>, this.value)" class="text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200 bg-slate-50 text-slate-700 focus:outline-none focus:border-[#0F4C81] transition cursor-pointer">
                                    <option value="proses" <?= $app['status'] === 'proses' ? 'selected' : '' ?>>⏳ Proses</option>
                                    <option value="lolos" <?= $app['status'] === 'lolos' ? 'selected' : '' ?>>✅ Lolos</option>
                                    <option value="tidak_lolos" <?= $app['status'] === 'tidak_lolos' ? 'selected' : '' ?>>❌ Tidak Lolos</option>
                                </select>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-400 font-medium"><?= date('d/m/Y', strtotime($app['applied_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-10 text-slate-400 text-xs">
                                <i class="fa-solid fa-users-slash text-2xl mb-2 text-slate-300 block"></i>
                                Belum ada berkas pelamar yang masuk.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TAB 4: MANAJEMEN USER -->
<div id="tab-users" class="tab-content hidden space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h2 class="font-extrabold text-[#0D1033] text-base">Manajemen Pengguna Aplikasi</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0D1033] text-white text-[11px] uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-6">Nama User</th>
                        <th class="py-3.5 px-6">Email</th>
                        <th class="py-3.5 px-6">Status Akun</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs sm:text-sm text-slate-700">
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 font-bold text-[#0D1033]"><?= htmlspecialchars($user['name']) ?></td>
                            <td class="py-4 px-6 text-slate-500 font-medium"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1 px-3 py-1 text-[11px] font-bold rounded-full border <?= ($user['status'] ?? 'active') === 'active' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' ?>">
                                    <i class="fa-solid fa-circle text-[6px]"></i> <?= strtoupper($user['status'] ?? 'ACTIVE') ?>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center justify-center gap-2">
                                    <button onclick="toggleUserStatus(<?= $user['id'] ?>, '<?= ($user['status'] ?? '') === 'blocked' ? 'active' : 'blocked' ?>')" class="text-xs font-bold px-3 py-1.5 rounded-lg border transition cursor-pointer <?= ($user['status'] ?? '') === 'blocked' ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white border-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 border-slate-200' ?>">
                                        <i class="fa-solid fa-ban text-[11px] mr-1"></i> <?= ($user['status'] ?? '') === 'blocked' ? 'Unblock' : 'Blokir' ?>
                                    </button>
                                    <button onclick="resetPassword(<?= $user['id'] ?>)" class="text-xs font-bold bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg transition shadow-sm cursor-pointer">
                                        <i class="fa-solid fa-key text-[11px] mr-1"></i> Reset Pass
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-10 text-slate-400 text-xs">
                                <i class="fa-solid fa-user-slash text-2xl mb-2 text-slate-300 block"></i>
                                Belum ada data pengguna terdaftar.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JAVASCRIPT SWITCH TAB & AJAX HANDLER -->
<script>
function switchTab(tabName, btnElement) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    const target = document.getElementById('tab-' + tabName);
    if(target) target.classList.remove('hidden');
}

function updateApplicantStatus(id, status) {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('status', status);

    fetch('<?= BASE_URL ?>admin/update_applicant_status', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => { if(data.success) alert('Status berhasil diperbarui!'); });
}

function toggleUserStatus(id, status) {
    if(!confirm('Ubah status akses user ini?')) return;
    const formData = new FormData();
    formData.append('id', id);
    formData.append('status', status);

    fetch('<?= BASE_URL ?>admin/toggle_user_status', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => { if(data.success) location.reload(); });
}

function resetPassword(id) {
    if(!confirm('Reset password user ini ke default (12345678)?')) return;
    const formData = new FormData();
    formData.append('id', id);

    fetch('<?= BASE_URL ?>admin/reset_password', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => { if(data.success) alert('Password berhasil di-reset!'); });
}

function deleteJob(id) {
    if(!confirm('Hapus lowongan ini?')) return;
    const formData = new FormData();
    formData.append('id', id);

    fetch('<?= BASE_URL ?>admin/delete_job', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => { if(data.success) location.reload(); });
}
</script>