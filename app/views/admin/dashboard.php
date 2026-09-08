<?php 
require_once ROOT_PATH . 'app/views/ekstra/header.php';
?>

<!-- Tag Pemanggil CSS Futuristik -->
<link rel="stylesheet" href="<?= BASE_URL; ?>public/css/dashboard-futuristic.css?v=<?= time(); ?>">

<!-- MAIN CONTENT AREA -->
<main class="main-content">

    <!-- STATS CARDS OVERVIEW (5 Card Visual Futuristik) -->
    <div class="stats-grid">
        <!-- Card 1: Lowongan Aktif -->
        <div class="stat-card cyan">
            <div class="stat-graphic">
                <div class="donut-ring" data-value="<?= $data['total_jobs_active'] ?? '15'; ?>"></div>
            </div>
            <div class="stat-card-title">Lowongan aktif</div>
        </div>

        <!-- Card 2: Total Lamaran -->
        <div class="stat-card orange">
            <div class="stat-graphic">
                <div class="donut-ring" data-value="<?= $data['total_applicants'] ?? '70%'; ?>"></div>
            </div>
            <div class="stat-card-title">Total lamaran</div>
        </div>

        <!-- Card 3: Alumni Terserap -->
        <div class="stat-card blue">
            <div class="stat-graphic">
                <div class="wave-chart">
                    <div class="wave-bar" style="height: 30%;"></div>
                    <div class="wave-bar" style="height: 50%;"></div>
                    <div class="wave-bar" style="height: 80%;"></div>
                    <div class="wave-bar" style="height: 65%;"></div>
                    <div class="wave-bar" style="height: 100%;"></div>
                </div>
            </div>
            <div class="stat-card-title">Alumni terserap masuk</div>
        </div>

        <!-- Card 4: Akun Terdaftar -->
        <div class="stat-card pink">
            <div class="stat-graphic">
                <i class="fa-solid fa-shapes text-4xl text-pink-500 opacity-80"></i>
            </div>
            <div class="stat-card-title">Akun terdaftar</div>
        </div>

        <!-- Card 5: Aktivitas -->
        <div class="stat-card blue">
            <div class="stat-graphic">
                <div class="wave-chart">
                    <div class="wave-bar" style="height: 40%; background: #00f0ff;"></div>
                    <div class="wave-bar" style="height: 70%; background: #00f0ff;"></div>
                    <div class="wave-bar" style="height: 100%; background: #ff7b00;"></div>
                    <div class="wave-bar" style="height: 80%; background: #ff7b00;"></div>
                    <div class="wave-bar" style="height: 50%; background: #e91e63;"></div>
                </div>
            </div>
            <div class="stat-card-title">Aktivitas</div>
        </div>
    </div>

    <!-- SECTION 1: LAMARAN TERBARU -->
    <section id="section-dashboard" class="admin-section active-section">
        <div class="section-title-bar">
            <span>Tanggal melamar ▼</span>
            <span>Nama pelamar ▼</span>
            <span>Posisi ▼</span>
            <span>Lowongan ▼</span>
            <span>Status ▼</span>
            <span>Aksi ▼</span>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <tbody>
                    <?php if (!empty($data['recent_applications'])) : ?>
                        <?php foreach ($data['recent_applications'] as $app) : ?>
                            <tr>
                                <td><?= date('d-m-Y', strtotime($app['created_at'])); ?></td>
                                <td><?= htmlspecialchars($app['nama_lengkap']); ?></td>
                                <td><?= htmlspecialchars($app['judul_lowongan']); ?></td>
                                <td><?= htmlspecialchars($app['kategori'] ?? 'Umum'); ?></td>
                                <td><span class="badge bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full border border-emerald-500/30"><?= $app['status']; ?></span></td>
                                <td style="text-align: center;">
                                    <a href="<?= BASE_URL; ?>admin/detail_lamaran/<?= $app['id_lamaran']; ?>" class="btn-pill btn-pill-blue">
                                        <i class="fa-solid fa-pen"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" style="text-align:center; padding: 40px; color: var(--text-sub); font-size: 1.1rem;">
                                Belum ada lamaran terbaru
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- SECTION 2: DAFTAR LOWONGAN -->
    <section id="section-jobs" class="admin-section" style="display: none;">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Judul lowongan</th>
                        <th>Kategori / Tipe</th>
                        <th>Batas akhir</th>
                        <th style="text-align: center; width: 220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['jobs_list'])) : ?>
                        <?php $no = 1; foreach ($data['jobs_list'] as $job) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><strong><?= htmlspecialchars($job['judul']); ?></strong></td>
                                <td><?= htmlspecialchars($job['perusahaan'] ?? 'PT Media'); ?> (Full Time)</td>
                                <td><?= htmlspecialchars($job['tanggal_tutup'] ?? '02-09-2026'); ?> 11:58:35</td>
                                <td style="text-align: center;">
                                    <a href="<?= BASE_URL; ?>admin/edit_lowongan/<?= $job['id']; ?>" class="btn-pill btn-pill-blue">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                    <a href="<?= BASE_URL; ?>admin/hapus_lowongan/<?= $job['id']; ?>" class="btn-pill btn-pill-pink" onclick="return confirm('Hapus lowongan ini?')">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td>1</td>
                            <td>Customer Support Specialist</td>
                            <td>PT Media Karya Sentosa (Full Time)</td>
                            <td>02-09-2026 11:58:35</td>
                            <td style="text-align: center;">
                                <a href="#" class="btn-pill btn-pill-blue"><i class="fa-solid fa-pen"></i> Edit</a>
                                <a href="#" class="btn-pill btn-pill-pink"><i class="fa-solid fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Staff administrasi digital</td>
                            <td>PT Utama Jaya Mandiri (Full Time)</td>
                            <td>02-09-2026 11:58:35</td>
                            <td style="text-align: center;">
                                <a href="#" class="btn-pill btn-pill-blue"><i class="fa-solid fa-pen"></i> Edit</a>
                                <a href="#" class="btn-pill btn-pill-pink"><i class="fa-solid fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Graphic designer & UI/UX</td>
                            <td>Studio Visual Cipta (Full Time)</td>
                            <td>02-09-2026 11:58:35</td>
                            <td style="text-align: center;">
                                <a href="#" class="btn-pill btn-pill-blue"><i class="fa-solid fa-pen"></i> Edit</a>
                                <a href="#" class="btn-pill btn-pill-pink"><i class="fa-solid fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- SECTION 3: KELOLA PELAMAR -->
    <section id="section-applicants" class="admin-section" style="display: none;">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelamar</th>
                        <th>Lowongan Dilamar</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align:center; padding: 30px; color: var(--text-sub);">
                            Data kelola pelamar akan tampil di sini.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- SECTION 4: KELOLA USER -->
    <section id="section-users" class="admin-section" style="display: none;">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" style="text-align:center; padding: 30px; color: var(--text-sub);">
                            Data kelola user akan tampil di sini.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

</main>

<!-- SWITCH TAB JS -->
<script>
    function switchTab(tabName, element) {
        document.querySelectorAll('.admin-section').forEach(sec => sec.style.display = 'none');
        
        const target = document.getElementById('section-' + tabName);
        if(target) target.style.display = 'block';
    }
</script>

<?php 
if (file_exists(ROOT_PATH . 'app/views/ekstra/footer.php')) {
    require_once ROOT_PATH . 'app/views/ekstra/footer.php';
} else {
    echo '</body></html>';
}
?>