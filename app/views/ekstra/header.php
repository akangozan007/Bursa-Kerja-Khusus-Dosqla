<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Filter Belum Login -> Redirect ke Page Login
if (!isset($_SESSION['user']) && !isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu.";
    header("Location: " . BASE_URL . "login");
    exit;
}

// 2. Deteksi Role User
$role = strtolower($_SESSION['role'] ?? $_SESSION['user']['role'] ?? 'pelamar');

// 3. Validasi Proteksi Halaman Berdasarkan Role yang Diizinkan
if (isset($allowedRole)) {
    if ($allowedRole === 'admin' && $role !== 'admin') {
        header("Location: " . BASE_URL . "pelamar");
        exit;
    } elseif ($allowedRole === 'pelamar' && $role !== 'pelamar') {
        header("Location: " . BASE_URL . "admin");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'BKK DOSQLA'; ?></title>
    
    <?php if ($role === 'admin'): ?>
        <!-- Style Khusus Admin (Sidebar Layout) -->
        <style>
            * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
            body { margin: 0; padding: 0; background-color: #f4f6f9; display: flex; }
            .sidebar { width: 240px; height: 100vh; background-color: #2c3e50; color: #fff; position: fixed; padding: 20px 0; }
            .sidebar h3 { text-align: center; margin-bottom: 20px; font-size: 1.2rem; color: #ecf0f1; border-bottom: 1px solid #34495e; padding-bottom: 15px; }
            .sidebar button, .sidebar a.btn-nav { display: block; width: 100%; padding: 12px 20px; background: none; color: #bdc3c7; border: none; text-align: left; font-size: 0.95rem; cursor: pointer; text-decoration: none; transition: 0.2s; }
            .sidebar button:hover, .sidebar a.btn-nav:hover { background-color: #34495e; color: #fff; }
            .sidebar .btn-logout { margin-top: 30px; color: #e74c3c; font-weight: bold; }
            .sidebar .btn-logout:hover { background-color: #c0392b; color: #fff; }
            .main-content { margin-left: 240px; padding: 30px; width: calc(100% - 240px); }
            .tab-content { display: none; }
            .tab-content.active { display: block; }
        </style>
    <?php else: ?>
        <!-- Asset Khusus Pelamar (Tailwind & FontAwesome) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <?php endif; ?>
</head>
<body class="<?= $role === 'pelamar' ? 'bg-gray-50 text-gray-800 font-sans' : '' ?>">

<?php if ($role === 'admin'): ?>
    <!-- Layout Sidebar untuk Admin -->
    <div class="sidebar">
        <h3>BKK DOSQLA</h3>
        <button onclick="openTab('dashboard')">Dashboard</button>
        <button onclick="openTab('jobs')">Kelola Lowongan</button>
        <button onclick="openTab('pelamar')">Kelola Pelamar</button>
        <button onclick="openTab('users')">Kelola User</button>
        <a href="<?= BASE_URL ?>logout" class="btn-nav btn-logout">🚪 Logout</a>
    </div>
    <div class="main-content">
<?php else: ?>
    <!-- Layout Navbar Topbar untuk Pelamar -->
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <img src="<?= BASE_URL ?>public/img/logo.png" alt="Logo BKK" class="h-9 w-auto">
                    <span class="font-bold text-xl tracking-wide">BKK DOSQLA</span>
                </div>
                <div class="flex items-center space-x-4 text-sm font-medium">
                    <a href="<?= BASE_URL ?>jobs" class="hover:bg-blue-700 px-3 py-2 rounded-lg transition">Cari Lowongan</a>
                    <a href="<?= BASE_URL ?>pelamar" class="bg-blue-800 px-3 py-2 rounded-lg">Riwayat Lamaran</a>
                    <a href="<?= BASE_URL ?>applicant/profile" class="hover:bg-blue-700 px-3 py-2 rounded-lg transition">Profil Saya</a>
                    <a href="<?= BASE_URL ?>logout" class="bg-orange-500 hover:bg-orange-600 px-3 py-2 rounded-lg transition font-semibold">Keluar</a>
                </div>
            </div>
        </div>
    </nav>
<?php endif; ?>