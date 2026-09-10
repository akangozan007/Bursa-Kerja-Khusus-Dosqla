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

// Deteksi segmen URL untuk menandai link aktif
$currentUrl = $_GET['url'] ?? 'admin';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'BKK DOSQLA'; ?></title>
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables Bootstrap 5 CSS CDN -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

    <!-- Load Tailwind CSS & FontAwesome secara Global -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Font (Inter & Plus Jakarta Sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- jQuery JS CDN (Wajib untuk DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables Core & Integration JS CDN -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- Custom Futuristic Styling untuk DataTables & UI Component -->
    <style>
        body { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        
        .glass-nav {
            background: rgba(37, 99, 235, 0.92) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.active .page-link {
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        .dataTables_wrapper .dataTables_paginate .page-link {
            border-radius: 0.5rem;
            margin: 0 2px;
            color: #475569;
            font-weight: 500;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            padding: 0.4rem 0.8rem;
            outline: none;
            transition: all 0.2s ease-in-out;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            padding: 0.3rem 2rem 0.3rem 0.8rem;
        }
        table.dataTable {
            border-collapse: separate !important;
            border-spacing: 0 0.5rem !important;
        }
        table.dataTable tbody tr {
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border-radius: 0.5rem;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        table.dataTable tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        }
        table.dataTable tbody td {
            border: none !important;
            padding: 1rem 0.75rem !important;
            vertical-align: middle;
        }
        table.dataTable thead th {
            border-bottom: none !important;
            color: #64748b;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
        }
    </style>
    <link rel="stylesheet" href="<?= BASE_URL; ?>public/css/dashboard-futuristic.css?v=<?= time(); ?>">
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen">

<?php if ($role === 'admin'): ?>
    <!-- ============================================== -->
    <!--          NAVIGASI ADMIN (FUTURISTIK)           -->
    <!-- ============================================== -->
    <nav class="glass-nav text-white shadow-lg sticky top-0 z-30 border-b border-blue-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo & Brand Admin -->
                <a href="<?= BASE_URL ?>admin" class="flex items-center gap-3 no-underline text-white">
                    <img src="<?= BASE_URL ?>public/img/logo.png" alt="Logo BKK" class="h-9 w-auto drop-shadow" onerror="this.onerror=null; this.src='https://via.placeholder.com/36?text=BKK';">
                    <div>
                        <span class="font-extrabold text-xl tracking-wide block leading-none">BKK DOSQLA</span>
                        <span class="text-[10px] text-blue-200 font-semibold tracking-wider uppercase">Admin Panel</span>
                    </div>
                </a>

                <!-- Navigasi Menu Admin -->
                <div class="flex items-center space-x-1 sm:space-x-2 text-sm font-medium">
                    <a href="<?= BASE_URL ?>admin" 
                       class="<?= ($currentUrl === 'admin' || $currentUrl === 'admin/index') ? 'bg-white/20 text-white font-semibold' : 'hover:bg-white/10 text-white/90' ?> px-3 py-2 rounded-lg transition duration-150 flex items-center gap-2 no-underline">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="<?= BASE_URL ?>admin/kelola-lowongan" 
                       class="<?= strpos($currentUrl, 'kelola-lowongan') !== false ? 'bg-white/20 text-white font-semibold' : 'hover:bg-white/10 text-white/90' ?> px-3 py-2 rounded-lg transition duration-150 flex items-center gap-2 no-underline">
                        <i class="fa-solid fa-briefcase"></i>
                        <span>Kelola Lowongan</span>
                    </a>

                    <a href="<?= BASE_URL ?>admin/kelola-pelamar" 
                       class="<?= strpos($currentUrl, 'kelola-pelamar') !== false ? 'bg-white/20 text-white font-semibold' : 'hover:bg-white/10 text-white/90' ?> px-3 py-2 rounded-lg transition duration-150 flex items-center gap-2 no-underline">
                        <i class="fa-solid fa-id-card"></i>
                        <span>Kelola Pelamar</span>
                    </a>

                    <a href="<?= BASE_URL ?>admin/kelola-user" 
                       class="<?= strpos($currentUrl, 'kelola-user') !== false ? 'bg-white/20 text-white font-semibold' : 'hover:bg-white/10 text-white/90' ?> px-3 py-2 rounded-lg transition duration-150 flex items-center gap-2 no-underline">
                        <i class="fa-solid fa-users-gear"></i>
                        <span>Kelola User</span>
                    </a>

                    <a href="<?= BASE_URL ?>logout" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg transition duration-150 font-semibold shadow-md hover:shadow-lg ml-2 no-underline">
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
    <nav class="glass-nav text-white shadow-lg sticky top-0 z-30 border-b border-blue-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo & Title -->
                <a href="<?= BASE_URL ?>jobs" class="flex items-center gap-3 no-underline text-white">
                    <img src="<?= BASE_URL ?>public/img/logo.png" alt="Logo BKK" class="h-9 w-auto drop-shadow" onerror="this.onerror=null; this.src='https://via.placeholder.com/36?text=BKK';">
                    <span class="font-extrabold text-xl tracking-wide">BKK DOSQLA</span>
                </a>

                <!-- Navigasi Menu Pelamar -->
                <div class="flex items-center space-x-2 sm:space-x-4 text-sm font-medium">
                    <a href="<?= BASE_URL ?>jobs" class="hover:bg-white/10 px-3 py-2 rounded-lg transition duration-150 no-underline text-white">Cari Lowongan</a>
                    <a href="<?= BASE_URL ?>pelamar" class="bg-white/20 px-3 py-2 rounded-lg shadow-inner no-underline text-white">Riwayat Lamaran</a>
                    <a href="<?= BASE_URL ?>pelamar/profile" class="hover:bg-white/10 px-3 py-2 rounded-lg transition duration-150 no-underline text-white">Profil Saya</a>
                    <a href="<?= BASE_URL ?>logout" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg transition duration-150 font-semibold shadow-md hover:shadow-lg ml-2 no-underline">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <!-- Container Utama Halaman Pelamar -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
<?php endif; ?>