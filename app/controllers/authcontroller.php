<?php

class AuthController {

    // Menampilkan Halaman Login
    public function index() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'pelamar');
            exit;
        }

        require_once ROOT_PATH . 'app/views/auth/login.php';
    }

    // Alias jika URL dipanggil via /auth/login
    public function login() {
        $this->index();
    }

    // Memproses Form Login (POST)
    public function process_login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = $_POST['password'] ?? '';

            if (!empty($username) && !empty($password)) {
                $_SESSION['user_id'] = 1;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'pelamar';

                header('Location: ' . BASE_URL . 'pelamar');
                exit;
            } else {
                $_SESSION['error'] = 'Username atau Password tidak boleh kosong!';
                header('Location: ' . BASE_URL . 'auth');
                exit;
            }
        } else {
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }
    }

    // Memproses Logout
    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . 'auth');
        exit;
    }
}