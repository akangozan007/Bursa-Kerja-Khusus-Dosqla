<?php

class AuthController {

    // 1. Menampilkan Halaman Login (URL: localhost/Bursa-Kerja-Khusus-Dosqla/auth)
    public function index() {
        // Cek jika sudah login, langsung lempar ke dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'pelamar');
            exit;
        }

        require_once ROOT_PATH . 'app/views/auth/login.php';
    }

    // 2. Memproses Data Form Login (POST Action)
    public function process_login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = $_POST['password'] ?? '';

            // TODO: Integrasikan dengan Model User untuk verifikasi database
            // Contoh validasi sederhana:
            if (!empty($username) && !empty($password)) {
                
                // Simpan session (contoh dummy)
                $_SESSION['user_id'] = 1;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'pelamar';

                // Redirect sesuai role
                header('Location: ' . BASE_URL . 'pelamar');
                exit;
            } else {
                $_SESSION['error'] = 'Username atau Password tidak boleh kosong!';
                header('Location: ' . BASE_URL . 'auth');
                exit;
            }
        } else {
            // Jika diakses langsung tanpa method POST
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }
    }

    // 3. Memproses Logout
    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . 'auth');
        exit;
    }
}