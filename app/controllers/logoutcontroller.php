<?php

class LogoutController {

    // Method utama yang otomatis dipanggil oleh Router saat URL /logout diakses
    public function index() {
        // 1. Hapusi semua variabel session
        $_SESSION = array();

        // 2. Hapus cookie session jika ada
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // 3. Hancurkan session
        session_destroy();

        // 4. Redirect kembali ke halaman login
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
}