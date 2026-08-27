<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - BKK DOSQLA</title>
    <style>
        .tab-content { display: none; }
        .tab-content.active { display: block; }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <button onclick="openTab('dashboard')">Dashboard</button>
        <button onclick="openTab('jobs')">Kelola Lowongan</button>
        <button onclick="openTab('pelamar')">Kelola Pelamar</button>
        <button onclick="openTab('users')">Kelola User</button>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- TAB 1: DASHBOARD MINI -->
        <div id="dashboard" class="tab-content active">
            <h2>Dashboard Ringkasan</h2>
            <p>Total Lowongan: <?= $data['total_jobs']; ?></p>
        </div>

        <!-- TAB 2: MANAJEMEN JOB -->
        <div id="jobs" class="tab-content">
            <h2>CRUD Lowongan Kerja</h2>
            <!-- Form & Tabel Job -->
        </div>

        <!-- TAB 3: MANAJEMEN PELAMAR -->
        <div id="pelamar" class="tab-content">
            <h2>Daftar Pelamar & Verifikasi</h2>
            <!-- Tabel Pelamar & Link Download File Uploads -->
        </div>

        <!-- TAB 4: MANAJEMEN USER -->
        <div id="users" class="tab-content">
            <h2>Kelola Akun Alumni / User</h2>
            <!-- Tabel User & Reset Password -->
        </div>
    </div>

    <script>
        function openTab(tabName) {
            let contents = document.querySelectorAll('.tab-content');
            contents.forEach(el => el.classList.remove('active'));
            document.getElementById(tabName).classList.add('active');
        }
    </script>
</body>
</html>