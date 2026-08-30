<?php

class PelamarController {

    public function index() {
        // 1. Cek Autentikasi Session
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }

        // 2. Cek Role Access Control
        if (isset($_SESSION['role']) && $_SESSION['role'] !== 'pelamar') {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }

        // 3. Muat View Dashboard Pelamar
        if (file_exists(ROOT_PATH . 'app/views/applicant/dashboard.php')) {
            require_once ROOT_PATH . 'app/views/applicant/dashboard.php';
        } else {
            echo "File view <strong>app/views/applicant/dashboard.php</strong> belum tersedia.";
        }
    }
}