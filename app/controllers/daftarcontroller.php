<?php

class DaftarController {

    private $userModel;

    public function __construct() {
        require_once ROOT_PATH . 'app/models/user.php';
        $this->userModel = new User();
    }

    // 1. Form Register User/Pelamar
    public function index() {
        require_once ROOT_PATH . 'app/views/auth/daftar.php';
    }

    // 2. Form Register Admin Rahasia (/auth/adminxxx)
    public function adminxxx() {
        require_once ROOT_PATH . 'app/views/auth/admin_register.php';
    }

    // 3. Process Register User
    public function process_register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        $email    = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));$password = trim($_POST['password'] ?? '');$instansi = trim(filter_input(INPUT_POST, 'instansi', FILTER_SANITIZE_SPECIAL_CHARS));

    if (empty($email) || empty($username) || empty($password) || empty($instansi)) {
            $_SESSION['error'] = 'Semua bidang input wajib diisi!';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {$_SESSION['error'] = 'Format email tidak valid!';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        if ($this->userModel->checkEmailExists($email)) {$_SESSION['error'] = 'Email sudah terdaftar!';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        if ($this->userModel->checkUsernameExists($username)) {$_SESSION['error'] = 'Username sudah terdaftar!';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'email'    => $email,
            'username' => $username,
            'password' => $hashedPassword,
            'instansi' => $instansi,
            'role'     => 'pelamar'
        ];

        if ($this->userModel->register($data)) {$_SESSION['success'] = 'Pendaftaran berhasil! Silakan login.';
            header('Location: ' . BASE_URL . 'auth');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal mendaftar, terjadi kesalahan sistem.';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }
    }

    // 4. Process Register Admin
    public function process_admin_register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'auth/adminxxx');
            exit;
        }

        $email     = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));$username  = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
        $password  = trim($_POST['password'] ?? '');
        $secretKey = trim($_POST['secret_key'] ?? '');

        $VALID_ADMIN_KEY = 'DOSQLA2026';

        if ($secretKey !== $VALID_ADMIN_KEY) {$_SESSION['error'] = 'Kode Rahasia Admin Salah!';
            header('Location: ' . BASE_URL . 'auth/adminxxx');
            exit;
        }

        if (empty($email) || empty($username) || empty($password)) {
            $_SESSION['error'] = 'Semua bidang wajib diisi!';
            header('Location: ' . BASE_URL . 'auth/adminxxx');
            exit;
        }

        if ($this->userModel->checkEmailExists($email) || $this->userModel->checkUsernameExists($username)) {
            $_SESSION['error'] = 'Email atau Username sudah terdaftar!';
            header('Location: ' . BASE_URL . 'auth/adminxxx');
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'email'    => $email,
            'username' => $username,
            'password' => $hashedPassword,
            'instansi' => 'Pengelola BKK',
            'role'     => 'admin'
        ];

        if ($this->userModel->register($data)) {$_SESSION['success'] = 'Akun Admin Berhasil Dibuat! Silakan Login.';
            header('Location: ' . BASE_URL . 'auth');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal mendaftarkan Admin.';
            header('Location: ' . BASE_URL . 'auth/adminxxx');
            exit;
        }
    }
} // <--- Jangan lupa kurung penutup kelas ini