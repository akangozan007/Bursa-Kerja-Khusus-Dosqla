<!-- TAB 1: DASHBOARD MINI -->
<div id="tab-dashboard" class="tab-content space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="text-sm font-medium text-slate-500">Lowongan Aktif</div>
            <div class="text-3xl font-bold text-slate-800 mt-2"><?= $stats['total_jobs'] ?></div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="text-sm font-medium text-slate-500">Total Pelamar</div>
            <div class="text-3xl font-bold text-blue-600 mt-2"><?= $stats['total_applicants'] ?></div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="text-sm font-medium text-slate-500">Alumni Diterima</div>
            <div class="text-3xl font-bold text-emerald-600 mt-2"><?= $stats['total_hired'] ?></div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="text-sm font-medium text-slate-500">Total User Registered</div>
            <div class="text-3xl font-bold text-indigo-600 mt-2"><?= $stats['total_users'] ?></div>
        </div>
    </div>
</div>

<!-- TAB 2: MANAJEMEN LOWONGAN (CRUD) -->
<div id="tab-jobs" class="tab-content hidden space-y-6">
    <div class="flex justify-between items-center bg-white p-4 rounded-xl border border-slate-200">
        <h2 class="text-lg font-bold text-slate-800">Daftar Lowongan Pekerjaan</h2>
        <button onclick="openJobModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
            <i class="fa-solid fa-plus mr-1"></i> Tambah Lowongan
        </button>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
                <tr>
                    <th class="p-4">Posisi / Perusahaan</th>
                    <th class="p-4">Tgl Buka - Tutup</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $job): ?>
                <tr class="border-b border-slate-100 hover:bg-slate-50">
                    <td class="p-4">
                        <div class="font-bold text-slate-800"><?= htmlspecialchars($job['title']) ?></div>
                        <div class="text-xs text-slate-500"><?= htmlspecialchars($job['company']) ?></div>
                    </td>
                    <td class="p-4"><?= $job['open_date'] ?> s/d <?= $job['close_date'] ?></td>
                    <td class="p-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-md <?= $job['status'] === 'open' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' ?>">
                            <?= strtoupper($job['status']) ?>
                        </span>
                    </td>
                    <td class="p-4 text-center space-x-2">
                        <button onclick="deleteJob(<?= $job['id'] ?>)" class="text-rose-600 hover:text-rose-800"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- TAB 3: MANAJEMEN PELAMAR -->
<div id="tab-applicants" class="tab-content hidden space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
                <tr>
                    <th class="p-4">Nama Pelamar</th>
                    <th class="p-4">Lowongan</th>
                    <th class="p-4">Berkas CV</th>
                    <th class="p-4">Status Lamaran</th>
                    <th class="p-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applicants as $app): ?>
                <tr class="border-b border-slate-100 hover:bg-slate-50">
                    <td class="p-4">
                        <div class="font-bold text-slate-800"><?= htmlspecialchars($app['name']) ?></div>
                        <div class="text-xs text-slate-500"><?= htmlspecialchars($app['email']) ?></div>
                    </td>
                    <td class="p-4"><?= htmlspecialchars($app['job_title']) ?></td>
                    <td class="p-4">
                        <a href="<?= BASE_URL ?>public/uploads/<?= $app['cv_file'] ?>" target="_blank" class="text-blue-600 underline text-xs">
                            <i class="fa-solid fa-file-pdf mr-1"></i> Lihat CV
                        </a>
                    </td>
                    <td class="p-4">
                        <select onchange="updateApplicantStatus(<?= $app['app_id'] ?>, this.value)" class="text-xs font-semibold rounded-lg p-1.5 border border-slate-300">
                            <option value="proses" <?= $app['status'] === 'proses' ? 'selected' : '' ?>>Proses</option>
                            <option value="lolos" <?= $app['status'] === 'lolos' ? 'selected' : '' ?>>Lolos</option>
                            <option value="tidak_lolos" <?= $app['status'] === 'tidak_lolos' ? 'selected' : '' ?>>Tidak Lolos</option>
                        </select>
                    </td>
                    <td class="p-4 text-xs text-slate-400"><?= date('d/m/Y', strtotime($app['applied_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- TAB 4: MANAJEMEN USER -->
<div id="tab-users" class="tab-content hidden space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
                <tr>
                    <th class="p-4">Nama User</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Status Akun</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr class="border-b border-slate-100 hover:bg-slate-50">
                    <td class="p-4 font-bold text-slate-800"><?= htmlspecialchars($user['name']) ?></td>
                    <td class="p-4"><?= htmlspecialchars($user['email']) ?></td>
                    <td class="p-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-md <?= $user['status'] === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' ?>">
                            <?= strtoupper($user['status'] ?? 'ACTIVE') ?>
                        </span>
                    </td>
                    <td class="p-4 text-center space-x-2">
                        <button onclick="toggleUserStatus(<?= $user['id'] ?>, '<?= $user['status'] === 'blocked' ? 'active' : 'blocked' ?>')" class="text-xs bg-slate-200 hover:bg-slate-300 px-2 py-1 rounded">
                            <?= $user['status'] === 'blocked' ? 'Unblock' : 'Blokir' ?>
                        </button>
                        <button onclick="resetPassword(<?= $user['id'] ?>)" class="text-xs bg-amber-500 hover:bg-amber-600 text-white px-2 py-1 rounded">
                            Reset Pass
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- JAVASCRIPT SWITCH TAB & AJAX HANDLER -->
<script>
function switchTab(tabName, btnElement) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.getElementById('tab-' + tabName).classList.remove('hidden');
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