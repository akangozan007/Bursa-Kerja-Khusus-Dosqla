<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BKK DOSQLA</title>

    <!-- FontAwesome & CSS Utama/Admin -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL; ?>public/css/login.css">
    
    <style>
        :root {
            --bg-primary: #03142c;
            --bg-secondary: #082247;
            --card-bg: #0d2d5a;
            --accent-cyan: #00a5e3;
            --accent-green: #2ec4b6;
            --accent-amber: #ff9f1c;
            --accent-red: #e63946;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: rgba(0, 165, 227, 0.2);
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR STYLES */
        .sidebar {
            width: 260px;
            background-color: var(--bg-secondary);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 24px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .sidebar-menu li a:hover, 
        .sidebar-menu li.active a {
            color: #fff;
            background: rgba(0, 165, 227, 0.15);
            border-left: 4px solid var(--accent-cyan);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--border-color);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 10px;
            background: rgba(230, 57, 70, 0.15);
            color: var(--accent-red);
            border: 1px solid var(--accent-red);
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: var(--accent-red);
            color: #fff;
        }

        /* MAIN CONTENT AREA */
        .main-content {
            margin-left: 260px;
            flex-grow: 1;
            padding: 30px;
            background-color: var(--bg-primary);
        }

        .top-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        .user-profile-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--bg-secondary);
            padding: 8px 16px;
            border-radius: 30px;
            border: 1px solid var(--border-color);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--accent-cyan);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* STATS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 1.8rem;
            color: #fff;
        }

        .stat-info p {
            margin: 4px 0 0;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* TAB SECTIONS & CONTENT CARDS */
        .admin-section {
            display: none;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 30px;
        }

        .admin-section.active-section {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        /* BUTTONS */
        .btn-action {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-primary { background: var(--accent-cyan); color: #fff; }
        .btn-primary:hover { background: #0088bb; }
        .btn-sm { padding: 5px 10px; font-size: 0.8rem; }
        .btn-edit { background: var(--accent-amber); color: #fff; }
        .btn-danger { background: var(--accent-red); color: #fff; }

        /* TABLES */
        .table-responsive {
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-table th, .custom-table td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        .custom-table th {
            background: var(--card-bg);
            color: var(--accent-cyan);
            font-weight: 600;
        }

        .custom-table tr:hover {
            background: rgba(255,255,255,0.02);
        }

        /* BADGES & STATUS */
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success { background: rgba(46, 196, 182, 0.2); color: var(--accent-green); border: 1px solid var(--accent-green); }
        .badge-warning { background: rgba(255, 159, 28, 0.2); color: var(--accent-amber); border: 1px solid var(--accent-amber); }
        .badge-danger { background: rgba(230, 57, 70, 0.2); color: var(--accent-red); border: 1px solid var(--accent-red); }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR NAVIGATION -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="<?= BASE_URL; ?>public/img/logo.png" alt="Logo" style="max-height: 32px;" onerror="this.onerror=null; this.src='https://via.placeholder.com/32?text=BKK';">
            <span>BKK Admin Panel</span>
        </div>

        <ul class="sidebar-menu">
            <li class="active" onclick="switchTab('dashboard', this)">
                <a href="#dashboard"><i class="fa-solid fa-chart-pie"></i> Dashboard Overview</a>
            </li>
            <li onclick="switchTab('jobs', this)">
                <a href="#jobs"><i class="fa-solid fa-briefcase"></i> Kelola Lowongan</a>
            </li>
            <li onclick="switchTab('applicants', this)">
                <a href="#applicants"><i class="fa-solid fa-id-card"></i> Pelamar & Berkas</a>
            </li>
            <li onclick="switchTab('users', this)">
                <a href="#users"><i class="fa-solid fa-users-gear"></i> Kelola User/Alumni</a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="<?= BASE_URL; ?>auth/logout" class="btn-logout">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="main-content">
        
        <!-- TOP NAVBAR -->
        <header class="top-navbar">
            <div class="page-title">
                <h1 id="pageHeading">Dashboard Ringkasan</h1>
            </div>
            <div class="user-profile-badge">
                <div class="user-avatar">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <div style="font-weight: bold; font-size: 0.9rem;"><?= $_SESSION['user_admin']['username'] ?? 'Administrator'; ?></div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">Pengelola BKK</div>
                </div>
            </div>
        </header>

        <!-- STATS CARDS OVERVIEW (Dashboard Mini) -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(0, 165, 227, 0.2); color: var(--accent-cyan);">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $data['total_jobs_active'] ?? '0'; ?></h3>
                    <p>Lowongan Aktif</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(255, 159, 28, 0.2); color: var(--accent-amber);">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $data['total_applicants'] ?? '0'; ?></h3>
                    <p>Total Lamaran Masuk</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(46, 196, 182, 0.2); color: var(--accent-green);">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $data['total_alumni_placed'] ?? '0'; ?></h3>
                    <p>Alumni Terserap Kerja</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(230, 57, 70, 0.2); color: var(--accent-red);">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $data['total_registered_users'] ?? '0'; ?></h3>
                    <p>Akun User Terdaftar</p>
                </div>
            </div>
        </div>

        <!-- SECTION 1: DASHBOARD RINGKASAN -->
        <section id="section-dashboard" class="admin-section active-section">
            <div class="section-header">
                <h2><i class="fa-solid fa-clock-rotate-left"></i> Aktivitas & Lamaran Terbaru</h2>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Tgl Melamar</th>
                            <th>Nama Pelamar</th>
                            <th>Posisi Lowongan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['recent_applications'])) : ?>
                            <?php foreach ($data['recent_applications'] as $app) : ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($app['created_at'])); ?></td>
                                    <td><?= htmlspecialchars($app['nama_lengkap']); ?></td>
                                    <td><?= htmlspecialchars($app['judul_lowongan']); ?></td>
                                    <td>
                                        <?php 
                                            $badgeClass = 'badge-warning';
                                            if($app['status'] == 'Lolos') $badgeClass = 'badge-success';
                                            elseif($app['status'] == 'Tidak Lolos') $badgeClass = 'badge-danger';
                                        ?>
                                        <span class="badge <?= $badgeClass; ?>"><?= $app['status']; ?></span>
                                    </td>
                                    <td>
                                        <a href="<?= BASE_URL; ?>admin/detail_lamaran/<?= $app['id_lamaran']; ?>" class="btn-action btn-primary btn-sm"><i class="fa-solid fa-eye"></i> Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" style="text-align:center; color: var(--text-muted);">Belum ada lamaran terbaru.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 2: MANAJEMEN LOWONGAN KERJA -->
        <section id="section-jobs" class="admin-section">
            <div class="section-header">
                <h2><i class="fa-solid fa-briefcase"></i> Daftar Lowongan Pekerjaan</h2>
                <a href="<?= BASE_URL; ?>admin/tambah_lowongan" class="btn-action btn-primary"><i class="fa-solid fa-plus"></i> Tambah Lowongan</a>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Lowongan</th>
                            <th>Kategori / Tipe</th>
                            <th>Batas Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['jobs_list'])) : ?>
                            <?php $no = 1; foreach ($data['jobs_list'] as $job) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><strong><?= htmlspecialchars($job['judul']); ?></strong></td>
                                    <td><?= htmlspecialchars($job['kategori']); ?> (<?= htmlspecialchars($job['tipe']); ?>)</td>
                                    <td><?= date('d M Y', strtotime($job['tanggal_tutup'])); ?></td>
                                    <td>
                                        <a href="<?= BASE_URL; ?>admin/edit_lowongan/<?= $job['id']; ?>" class="btn-action btn-edit btn-sm"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                        <a href="<?= BASE_URL; ?>admin/hapus_lowongan/<?= $job['id']; ?>" class="btn-action btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')"><i class="fa-solid fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" style="text-align:center; color: var(--text-muted);">Belum ada lowongan pekerjaan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 3: MANAJEMEN PELAMAR & BERKAS -->
        <section id="section-applicants" class="admin-section">
            <div class="section-header">
                <h2><i class="fa-solid fa-id-card"></i> Data Pelamar & Dokumen CV</h2>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama Pelamar</th>
                            <th>Posisi Dilamar</th>
                            <th>Berkas CV</th>
                            <th>Ubah Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['all_applicants'])) : ?>
                            <?php foreach ($data['all_applicants'] as $applicant) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($applicant['nama_lengkap']); ?></td>
                                    <td><?= htmlspecialchars($applicant['judul_lowongan']); ?></td>
                                    <td>
                                        <a href="<?= BASE_URL; ?>public/uploads/<?= $applicant['file_cv']; ?>" target="_blank" class="btn-action btn-primary btn-sm">
                                            <i class="fa-solid fa-download"></i> Unduh CV
                                        </a>
                                    </td>
                                    <td>
                                        <!-- Form Ubah Status Lamaran Langsung -->
                                        <form action="<?= BASE_URL; ?>admin/update_status_lamaran" method="POST" style="display:flex; gap: 5px;">
                                            <input type="hidden" name="id_lamaran" value="<?= $applicant['id_lamaran']; ?>">
                                            <select name="status" style="padding: 4px; border-radius:4px; background: var(--bg-primary); color: #fff; border: 1px solid var(--border-color);">
                                                <option value="Diproses" <?= ($applicant['status'] == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                                                <option value="Lolos" <?= ($applicant['status'] == 'Lolos') ? 'selected' : ''; ?>>Lolos</option>
                                                <option value="Tidak Lolos" <?= ($applicant['status'] == 'Tidak Lolos') ? 'selected' : ''; ?>>Tidak Lolos</option>
                                            </select>
                                            <button type="submit" class="btn-action btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="<?= BASE_URL; ?>admin/detail_pelamar/<?= $applicant['id_user']; ?>" class="btn-action btn-edit btn-sm"><i class="fa-solid fa-user"></i> Detail User</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" style="text-align:center; color: var(--text-muted);">Tidak ada pelamar terdaftar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 4: MANAJEMEN USER / ALUMNI -->
        <section id="section-users" class="admin-section">
            <div class="section-header">
                <h2><i class="fa-solid fa-users-gear"></i> Kelola Akun User / Alumni</h2>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email Official</th>
                            <th>Status Akun</th>
                            <th>Aksi Kelola</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['users_list'])) : ?>
                            <?php $no = 1; foreach ($data['users_list'] as $user) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><strong><?= htmlspecialchars($user['username']); ?></strong></td>
                                    <td><?= htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <?php if($user['status_aktif'] == 1): ?>
                                            <span class="badge badge-success">Aktif / Terverifikasi</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Diblokir / Non-Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= BASE_URL; ?>admin/toggle_user_status/<?= $user['id']; ?>" class="btn-action <?= ($user['status_aktif'] == 1) ? 'btn-danger' : 'btn-primary'; ?> btn-sm">
                                            <?= ($user['status_aktif'] == 1) ? '<i class="fa-solid fa-ban"></i> Blokir' : '<i class="fa-solid fa-check"></i> Aktifkan'; ?>
                                        </a>
                                        <a href="<?= BASE_URL; ?>admin/reset_password/<?= $user['id']; ?>" class="btn-action btn-edit btn-sm" onclick="return confirm('Reset password user ini?')">
                                            <i class="fa-solid fa-key"></i> Reset Pass
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" style="text-align:center; color: var(--text-muted);">Belum ada data user alumni.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <!-- JAVASCRIPT NAVIGASI TAB MODERN -->
    <script>
        function switchTab(tabName, element) {
            // Unactivekan semua menu sidebar
            const menuItems = document.querySelectorAll('.sidebar-menu li');
            menuItems.forEach(item => item.classList.remove('active'));

            // Aktifkan item sidebar yang diklik
            element.classList.add('active');

            // Sembunyikan semua section
            const sections = document.querySelectorAll('.admin-section');
            sections.forEach(sec => sec.classList.remove('active-section'));

            // Tampilkan section yang dipilih
            const targetSection = document.getElementById('section-' + tabName);
            if(targetSection) {
                targetSection.classList.add('active-section');
            }

            // Update judul heading
            const headingMap = {
                'dashboard': 'Dashboard Ringkasan',
                'jobs': 'Manajemen Lowongan Pekerjaan',
                'applicants': 'Manajemen Pelamar & Dokumen CV',
                'users': 'Manajemen Akun User & Alumni'
            };
            document.getElementById('pageHeading').innerText = headingMap[tabName] || 'Admin Dashboard';
        }
    </script>
</body>
</html>