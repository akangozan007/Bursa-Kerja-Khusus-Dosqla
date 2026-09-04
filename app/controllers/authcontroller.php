<?php

class AuthController {

    private $userModel;

    public function __construct() {
        require_once ROOT_PATH . 'app/models/user.php';
        $this->userModel = new User();
    }

    /**
     * Halaman Utama Login / Pengecekan Sesi Aktif
     */
    public function index() {
        // 1. Cek jika user SUDAH LOGIN, langsung alihkan sesuai role-nya
        if ($this->isLoggedIn()) {
            $this->redirectBasedOnRole();
            exit;
        }

        // 2. Jika belum login, tampilkan halaman form login
        require_once ROOT_PATH . 'app/views/auth/login.php';
    }

    /**
     * Proses Verifikasi Login (POST Request)
     */
    public function process_login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }

        $emailOrUsername = trim($_POST['login_input'] ?? $_POST['username'] ?? '');
        $password        = trim($_POST['password'] ?? '');

        if (empty($emailOrUsername) || empty($password)) {
            $_SESSION['error'] = 'Email/Username dan Password wajib diisi!';
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }

        // Autentikasi user dari database melalui UserModel
        $user = $this->userModel->login($emailOrUsername, $password);

        if ($user) {
            // Cek status keaktifan akun (jika ada fitur blokir/non-aktif)
            if (isset($user['status_aktif']) && $user['status_aktif'] == 0) {
                $_SESSION['error'] = 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.';
                header('Location: ' . BASE_URL . 'auth');
                exit;
            }

            // Simpan data login utama ke session
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['email']     = $user['email'];
            $_SESSION['role']      = strtolower($user['role']); // 'admin' atau 'pelamar'

            // Simpan session spesifik role agar kompatibel dengan view yang ada
            if ($_SESSION['role'] === 'admin') {
                $_SESSION['user_admin'] = [
                    'id'       => $user['id'],
                    'username' => $user['username'],
                    'email'    => $user['email'],
                    'role'     => 'admin'
                ];
            } else {
                $_SESSION['user_applicant'] = [
                    'id'       => $user['id'],
                    'username' => $user['username'],
                    'email'    => $user['email'],
                    'role'     => 'pelamar'
                ];
            }

            // REDIREKSI SESUAI ROLE
            $this->redirectBasedOnRole();
            exit;

        } else {
            $_SESSION['error'] = 'Username/Email atau Password salah!';
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }
    }

    /**
     * Helper Private Function: Redireksi berdasarkan Role Sesi
     */
    private function redirectBasedOnRole() {
        $role = $_SESSION['role'] ?? '';

        if ($role === 'admin') {
            header('Location: ' . BASE_URL . 'admin/');
            exit;
        } elseif ($role === 'pelamar' || $role === 'applicant') {
            header('Location: ' . BASE_URL . 'applicant/dashboard');
            exit;
        } else {
            // Fallback jika role tidak terdefinisi
            header('Location: ' . BASE_URL);
            exit;
        }
    }

    /**
     * Helper Private Function: Cek status login
     */
    private function isLoggedIn() {
        return isset($_SESSION['user_id']) && isset($_SESSION['role']);
    }

    /**
     * Proses Logout
     */
    public function logout() {
        session_unset();
        session_destroy();
        
        session_start();
        $_SESSION['success'] = 'Anda telah berhasil keluar.';
        header('Location: ' . BASE_URL . 'auth');
        exit;
    }
}