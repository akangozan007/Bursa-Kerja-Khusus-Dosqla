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
    <!--            ADMIN LAYOUT MODERN                 -->
    <!-- ============================================== -->
    <div class="flex min-h-screen">
        
        <!-- SIDEBAR ADMIN -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between fixed h-full z-30 shadow-xl">
            <div>
                <!-- Brand Header -->
                <div class="h-16 flex items-center px-6 bg-slate-950/50 border-b border-slate-800 gap-3">
                    <img src="<?= BASE_URL ?>public/img/logo.png" alt="Logo BKK" class="h-8 w-auto" onerror="this.onerror=null; this.src='https://via.placeholder.com/32?text=BKK';">
                    <div>
                        <span class="font-bold text-lg tracking-wide text-white block leading-tight">BKK DOSQLA</span>
                        <span class="text-[10px] text-sky-400 font-semibold tracking-wider uppercase">Admin Dashboard</span>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="p-4 space-y-1 text-sm font-medium">
                    <button onclick="switchTab('dashboard', this)" class="sidebar-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition duration-200 active">
                        <i class="fa-solid fa-chart-pie w-5 text-sky-400 text-base"></i>
                        <span>Dashboard</span>
                    </button>
                    <button onclick="switchTab('jobs', this)" class="sidebar-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition duration-200">
                        <i class="fa-solid fa-briefcase w-5 text-amber-400 text-base"></i>
                        <span>Kelola Lowongan</span>
                    </button>
                    <button onclick="switchTab('applicants', this)" class="sidebar-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition duration-200">
                        <i class="fa-solid fa-id-card w-5 text-emerald-400 text-base"></i>
                        <span>Kelola Pelamar</span>
                    </button>
                    <button onclick="switchTab('users', this)" class="sidebar-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition duration-200">
                        <i class="fa-solid fa-users-gear w-5 text-indigo-400 text-base"></i>
                        <span>Kelola User</span>
                    </button>
                </nav>
            </div>

            <!-- Footer Sidebar / Logout -->
            <div class="p-4 border-t border-slate-800/80">
                <a href="<?= BASE_URL ?>logout" class="flex items-center gap-3 px-4 py-3 rounded-xl text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition duration-200 text-sm font-medium">
                    <i class="fa-solid fa-right-from-bracket w-5 text-base"></i>
                    <span>Keluar Sistem</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 ml-64 flex flex-col min-h-screen">
            
            <!-- TOPBAR ADMIN -->
            <header class="h-16 bg-white border-b border-slate-200 shadow-sm flex items-center justify-between px-8 sticky top-0 z-20">
                <div class="flex items-center gap-3">
                    <h1 id="pageHeading" class="text-xl font-bold text-slate-800">Dashboard Ringkasan</h1>
                </div>

                <!-- User Profile Badge Topbar -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                        <div class="w-9 h-9 rounded-full bg-slate-900 text-sky-400 flex items-center justify-center font-bold text-sm shadow-sm border border-slate-700">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <div class="hidden sm:block text-left">
                            <span class="block text-sm font-semibold text-slate-800 leading-tight">
                                <?= $_SESSION['user_admin']['username'] ?? $_SESSION['user']['username'] ?? 'Administrator'; ?>
                            </span>
                            <span class="block text-xs font-medium text-slate-500">Super Admin</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Container Konten Utama -->
            <main class="p-8 flex-1">

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