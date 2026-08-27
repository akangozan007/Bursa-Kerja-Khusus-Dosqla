<?php

class AdminController {

    public function __construct() {
        // Keamanan: Cek Session Login & Role Admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }
    }

    // Menampilkan halaman Single-File Panel Admin
    public function index() {
        require_once ROOT_PATH . 'app/models/Job.php';
        require_once ROOT_PATH . 'app/models/User.php';

        $jobModel = new Job();
        $userModel = new User();

        // Ambil data untuk Dashboard Ringkasan & Tabel
        $data = [
            'jobs'       => $jobModel->getAllJobs(),
            'total_jobs' => count($jobModel->getAllJobs()),
            // Tambahkan data statistik/pelamar lainnya di sini...
        ];

        require_once ROOT_PATH . 'app/views/admin.php';
    }

    // Method untuk Olah Data (CRUD Action)
    public function create_job() {
        // Logika simpan job baru via Form/AJAX
    }

    public function update_status_pelamar() {
        // Logika update status lamaran
    }
}