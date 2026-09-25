<?php 
$pageTitle = "Dashboard Admin - BKK DOSQLA";
require_once ROOT_PATH . 'app/views/ekstra/header.php';
?>

<!-- Custom Style BKK DOSQLA Theme Override -->
<style>
    :root {
        --bkk-navy-dark: #0D1033;
        --bkk-navy-blue: #0F4C81;
        --bkk-sky-blue: #71C9CE;
        --bkk-orange: #F2994A;
    }

    .bg-bkk-navy { background-color: var(--bkk-navy-dark); }
    .bg-bkk-blue { background-color: var(--bkk-navy-blue); }
    .text-bkk-navy { color: var(--bkk-navy-dark); }
    .text-bkk-blue { color: var(--bkk-navy-blue); }
    
    .btn-bkk-primary {
        background-color: var(--bkk-orange);
        color: #ffffff;
        transition: all 0.2s ease-in-out;
    }
    .btn-bkk-primary:hover {
        background-color: #e08332;
        box-shadow: 0 4px 12px rgba(242, 153, 74, 0.3);
    }

    .tab-btn.active {
        border-bottom-color: var(--bkk-orange);
        color: var(--bkk-navy-dark);
        font-weight: 700;
    }
</style>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header Welcome & Actions -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-100 text-xs text-[#0F4C81] font-semibold mb-2">
                <i class="fa-solid fa-user-shield"></i> Control Panel Admin
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0D1033] tracking-tight">
                Dashboard Ringkasan BKK
            </h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">
                Kelola data statistik lowongan, pelamar, dan akun dalam satu panel terpadu.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?= BASE_URL; ?>admin/tambah_lowongan" class="btn-bkk-primary px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-2 no-underline shadow-sm">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Lowongan
            </a>
        </div>
    </div>

    <!-- STATS CARDS OVERVIEW (5 Cards Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        
        <!-- Card 1: Lowongan Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Lowongan Aktif</span>
                <div class="w-9 h-9 bg-cyan-50 text-[#71C9CE] rounded-xl flex items-center justify-center text-sm border border-cyan-100">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-[#0D1033]"><?= $data['total_jobs_active'] ?? '15'; ?></p>
            <p class="text-[11px] text-emerald-600 font-medium mt-1 inline-flex items-center gap-1">
                <i class="fa-solid fa-circle text-[6px]"></i> Terpublikasi
            </p>
        </div>

        <!-- Card 2: Total Lamaran -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Lamaran</span>
                <div class="w-9 h-9 bg-amber-50 text-[#F2994A] rounded-xl flex items-center justify-center text-sm border border-amber-100">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-[#0D1033]"><?= $data['total_applicants'] ?? '128'; ?></p>
            <p class="text-[11px] text-amber-600 font-medium mt-1 inline-flex items-center gap-1">
                <i class="fa-solid fa-clock-rotate-left text-[10px]"></i> Masuk bulan ini
            </p>
        </div>

        <!-- Card 3: Alumni Terserap -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Alumni Terserap</span>
                <div class="w-9 h-9 bg-sky-50 text-[#0F4C81] rounded-xl flex items-center justify-center text-sm border border-sky-100">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-[#0D1033]">84%</p>
            <p class="text-[11px] text-sky-600 font-medium mt-1 inline-flex items-center gap-1">
                <i class="fa-solid fa-arrow-up-right-dots text-[10px]"></i> Meningkat
            </p>
        </div>

        <!-- Card 4: Akun Terdaftar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Akun Terdaftar</span>
                <div class="w-9 h-9 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-sm border border-purple-100">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-[#0D1033]">342</p>
            <p class="text-[11px] text-slate-400 font-medium mt-1">Alumni & Mitracomp</p>
        </div>

        <!-- Card 5: Aktivitas Portal -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aktivitas Hari Ini</span>
                <div class="w-9 h-9 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-sm border border-emerald-100">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-[#0D1033]">98.2%</p>
            <p class="text-[11px] text-emerald-600 font-medium mt-1 inline-flex items-center gap-1">
                <i class="fa-solid fa-circle text-[6px]"></i> System Normal
            </p>
        </div>

    </div>

    <!-- TAB NAVIGATION BAR -->
    <div class="border-b border-slate-200 mb-6 flex items-center gap-2 overflow-x-auto">
        <button onclick="switchTab('dashboard', this)" class="tab-btn active px-4 py-3 text-xs sm:text-sm font-semibold text-slate-500 border-b-2 border-transparent hover:text-[#0D1033] transition whitespace-nowrap">
            <i class="fa-solid fa-clock-rotate-left mr-1.5"></i> Lamaran Terbaru
        </button>
        <button onclick="switchTab('jobs', this)" class="tab-btn px-4 py-3 text-xs sm:text-sm font-semibold text-slate-500 border-b-2 border-transparent hover:text-[#0D1033] transition whitespace-nowrap">
            <i class="fa-solid fa-briefcase mr-1.5"></i> Daftar Lowongan
        </button>
        <button onclick="switchTab('applicants', this)" class="tab-btn px-4 py-3 text-xs sm:text-sm font-semibold text-slate-500 border-b-2 border-transparent hover:text-[#0D1033] transition whitespace-nowrap">
            <i class="fa-solid fa-users-gear mr-1.5"></i> Kelola Pelamar
        </button>
        <button onclick="switchTab('users', this)" class="tab-btn px-4 py-3 text-xs sm:text-sm font-semibold text-slate-500 border-b-2 border-transparent hover:text-[#0D1033] transition whitespace-nowrap">
            <i class="fa-solid fa-user-shield mr-1.5"></i> Kelola User
        </button>
    </div>

    <!-- SECTION 1: LAMARAN TERBARU -->
    <section id="section-dashboard" class="admin-section bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h2 class="font-extrabold text-[#0D1033] text-base">Lamaran Masuk Terbaru</h2>
            <span class="text-xs text-slate-400">Menampilkan berkas terbaru</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0D1033] text-white text-[11px] uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-6">Tanggal Melamar</th>
                        <th class="py-3.5 px-6">Nama Pelamar</th>
                        <th class="py-3.5 px-6">Posisi Lowongan</th>
                        <th class="py-3.5 px-6">Kategori</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs sm:text-sm text-slate-700">
                    <?php if (!empty($data['recent_applications'])) : ?>
                        <?php foreach ($data['recent_applications'] as $app) : ?>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-6 text-slate-500"><?= date('d-m-Y', strtotime($app['created_at'])); ?></td>
                                <td class="py-4 px-6 font-bold text-[#0D1033]"><?= htmlspecialchars($app['nama_lengkap']); ?></td>
                                <td class="py-4 px-6 font-medium text-slate-600"><?= htmlspecialchars($app['judul_lowongan']); ?></td>
                                <td class="py-4 px-6 text-slate-500"><?= htmlspecialchars($app['kategori'] ?? 'Umum'); ?></td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-full border border-emerald-200">
                                        <?= htmlspecialchars($app['status']); ?>
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <a href="<?= BASE_URL; ?>admin/detail_lamaran/<?= $app['id_lamaran']; ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-sky-50 text-[#0F4C81] hover:bg-[#0F4C81] hover:text-white rounded-lg font-bold text-xs transition no-underline border border-sky-100">
                                        <i class="fa-solid fa-pen-to-square"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400 text-sm">
                                <i class="fa-solid fa-inbox text-3xl mb-2 text-slate-300 block"></i>
                                Belum ada lamaran terbaru yang masuk.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- SECTION 2: DAFTAR LOWONGAN -->
    <section id="section-jobs" class="admin-section bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden" style="display: none;">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h2 class="font-extrabold text-[#0D1033] text-base">Manajemen Lowongan Pekerjaan</h2>
            <a href="<?= BASE_URL; ?>admin/tambah_lowongan" class="text-xs font-bold text-[#0F4C81] hover:underline">+ Buat Baru</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0D1033] text-white text-[11px] uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-6 w-12">No</th>
                        <th class="py-3.5 px-6">Judul Lowongan</th>
                        <th class="py-3.5 px-6">Perusahaan / Tipe</th>
                        <th class="py-3.5 px-6">Batas Akhir</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs sm:text-sm text-slate-700">
                    <?php if (!empty($data['jobs_list'])) : ?>
                        <?php $no = 1; foreach ($data['jobs_list'] as $job) : ?>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-6 text-slate-400 font-medium"><?= $no++; ?></td>
                                <td class="py-4 px-6 font-bold text-[#0D1033]"><?= htmlspecialchars($job['judul']); ?></td>
                                <td class="py-4 px-6 text-slate-600"><?= htmlspecialchars($job['perusahaan'] ?? 'PT Partner'); ?> (Full Time)</td>
                                <td class="py-4 px-6 text-slate-500"><?= htmlspecialchars($job['tanggal_tutup'] ?? '02-09-2026'); ?></td>
                                <td class="py-4 px-6 text-center">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="<?= BASE_URL; ?>admin/edit_lowongan/<?= $job['id']; ?>" class="px-3 py-1.5 bg-sky-50 text-[#0F4C81] hover:bg-[#0F4C81] hover:text-white rounded-lg font-bold text-xs transition no-underline border border-sky-100">
                                            <i class="fa-solid fa-pen"></i> Edit
                                        </a>
                                        <a href="<?= BASE_URL; ?>admin/hapus_lowongan/<?= $job['id']; ?>" onclick="return confirm('Hapus lowongan ini?')" class="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg font-bold text-xs transition no-underline border border-rose-100">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 text-slate-400 font-medium">1</td>
                            <td class="py-4 px-6 font-bold text-[#0D1033]">Customer Support Specialist</td>
                            <td class="py-4 px-6 text-slate-600">PT Media Karya Sentosa (Full Time)</td>
                            <td class="py-4 px-6 text-slate-500">02-09-2026 11:58:35</td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <a href="#" class="px-3 py-1.5 bg-sky-50 text-[#0F4C81] hover:bg-[#0F4C81] hover:text-white rounded-lg font-bold text-xs transition no-underline border border-sky-100"><i class="fa-solid fa-pen"></i> Edit</a>
                                    <a href="#" class="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg font-bold text-xs transition no-underline border border-rose-100"><i class="fa-solid fa-trash"></i> Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 text-slate-400 font-medium">2</td>
                            <td class="py-4 px-6 font-bold text-[#0D1033]">Staff Administrasi Digital</td>
                            <td class="py-4 px-6 text-slate-600">PT Utama Jaya Mandiri (Full Time)</td>
                            <td class="py-4 px-6 text-slate-500">02-09-2026 11:58:35</td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <a href="#" class="px-3 py-1.5 bg-sky-50 text-[#0F4C81] hover:bg-[#0F4C81] hover:text-white rounded-lg font-bold text-xs transition no-underline border border-sky-100"><i class="fa-solid fa-pen"></i> Edit</a>
                                    <a href="#" class="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg font-bold text-xs transition no-underline border border-rose-100"><i class="fa-solid fa-trash"></i> Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- SECTION 3: KELOLA PELAMAR -->
    <section id="section-applicants" class="admin-section bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden" style="display: none;">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h2 class="font-extrabold text-[#0D1033] text-base">Kelola Seluruh Pelamar</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0D1033] text-white text-[11px] uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-6">No</th>
                        <th class="py-3.5 px-6">Nama Pelamar</th>
                        <th class="py-3.5 px-6">Lowongan Dilamar</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs sm:text-sm text-slate-700">
                    <tr>
                        <td colspan="5" class="text-center py-12 text-slate-400">
                            <i class="fa-solid fa-users text-3xl mb-2 text-slate-300 block"></i>
                            Data kelola pelamar secara menyeluruh akan tampil di sini.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- SECTION 4: KELOLA USER -->
    <section id="section-users" class="admin-section bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden" style="display: none;">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h2 class="font-extrabold text-[#0D1033] text-base">Manajemen User System</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0D1033] text-white text-[11px] uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-6">No</th>
                        <th class="py-3.5 px-6">Username</th>
                        <th class="py-3.5 px-6">Role</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs sm:text-sm text-slate-700">
                    <tr>
                        <td colspan="4" class="text-center py-12 text-slate-400">
                            <i class="fa-solid fa-user-lock text-3xl mb-2 text-slate-300 block"></i>
                            Data pengelolaan akun pengguna (Admin / Pelamar / Perusahaan) akan tampil di sini.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

</main>

<!-- SWITCH TAB SCRIPT -->
<script>
    function switchTab(tabName, element) {
        // Sembunyikan semua section
        document.querySelectorAll('.admin-section').forEach(sec => sec.style.display = 'none');
        
        // Hapus status active di semua tombol tab
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

        // Tampilkan target section & tambahkan status active ke button yang diklik
        const target = document.getElementById('section-' + tabName);
        if (target) {
            target.style.display = 'block';
            element.classList.add('active');
        }
    }
</script>

<?php 
if (file_exists(ROOT_PATH . 'app/views/ekstra/footer.php')) {
    require_once ROOT_PATH . 'app/views/ekstra/footer.php';
} else {
    echo '</body></html>';
}
?>