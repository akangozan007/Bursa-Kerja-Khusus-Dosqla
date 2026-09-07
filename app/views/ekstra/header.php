<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Filter Belum Login -> Redirect ke Page Login
if (!isset($_SESSION['user']) && !isset($_SESSION['user_id']) && !isset($_SESSION['user_admin'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu.";
    header("Location: " . BASE_URL . "login");
    exit;
}

// 2. Deteksi Role User
$role = strtolower($_SESSION['role'] ?? $_SESSION['user']['role'] ?? $_SESSION['user_admin']['role'] ?? 'pelamar');

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
    
    <!-- Load Tailwind CSS & FontAwesome secara Global -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Font (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen">

<?php if ($role === 'admin'): ?>
    <!-- ============================================== -->
    <!--          NAVIGASI ADMIN (DESAIN PELAMAR)       -->
    <!-- ============================================== -->
    <nav class="bg-blue-600 text-white shadow-lg sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo & Brand Admin -->
                <div class="flex items-center gap-3">
                    <img src="<?= BASE_URL ?>public/img/logo.png" alt="Logo BKK" class="h-9 w-auto" onerror="this.onerror=null; this.src='https://via.placeholder.com/36?text=BKK';">
                    <div>
                        <span class="font-bold text-xl tracking-wide block leading-none">BKK DOSQLA</span>
                        <span class="text-[10px] text-blue-200 font-medium tracking-wider uppercase">Admin Panel</span>
                    </div>
                </div>

                <!-- Navigasi Menu Admin -->
                <div class="flex items-center space-x-1 sm:space-x-3 text-sm font-medium">
                    <button onclick="switchTab('dashboard', this)" class="hover:bg-blue-700/80 px-3 py-2 rounded-lg transition duration-150 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </button>
                    <button onclick="switchTab('jobs', this)" class="hover:bg-blue-700/80 px-3 py-2 rounded-lg transition duration-150 flex items-center gap-2">
                        <i class="fa-solid fa-briefcase"></i>
                        <span>Kelola Lowongan</span>
                    </button>
                    <button onclick="switchTab('applicants', this)" class="hover:bg-blue-700/80 px-3 py-2 rounded-lg transition duration-150 flex items-center gap-2">
                        <i class="fa-solid fa-id-card"></i>
                        <span>Kelola Pelamar</span>
                    </button>
                    <button onclick="switchTab('users', this)" class="hover:bg-blue-700/80 px-3 py-2 rounded-lg transition duration-150 flex items-center gap-2">
                        <i class="fa-solid fa-users-gear"></i>
                        <span>Kelola User</span>
                    </button>
                    <a href="<?= BASE_URL ?>logout" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg transition duration-150 font-semibold shadow-sm ml-2">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <!-- Container Utama Halaman Admin -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

<?php else: ?>
    <!-- ============================================== -->
    <!--            PELAMAR LAYOUT MODERN               -->
    <!-- ============================================== -->
    <nav class="bg-blue-600 text-white shadow-lg sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo & Title -->
                <div class="flex items-center gap-3">
                    <img src="<?= BASE_URL ?>public/img/logo.png" alt="Logo BKK" class="h-9 w-auto" onerror="this.onerror=null; this.src='https://via.placeholder.com/36?text=BKK';">
                    <span class="font-bold text-xl tracking-wide">BKK DOSQLA</span>
                </div>

                <!-- Navigasi Menu Pelamar -->
                <div class="flex items-center space-x-2 sm:space-x-4 text-sm font-medium">
                    <a href="<?= BASE_URL ?>jobs" class="hover:bg-blue-700/80 px-3 py-2 rounded-lg transition duration-150">Cari Lowongan</a>
                    <a href="<?= BASE_URL ?>pelamar" class="bg-blue-700/90 px-3 py-2 rounded-lg shadow-inner">Riwayat Lamaran</a>
                    <a href="<?= BASE_URL ?>pelamar/profile" class="hover:bg-blue-700/80 px-3 py-2 rounded-lg transition duration-150">Profil Saya</a>
                    <a href="<?= BASE_URL ?>logout" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg transition duration-150 font-semibold shadow-sm ml-2">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <!-- Container Utama Halaman Pelamar -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
<?php endif; ?>