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

    // 2. Form Register Admin Rahasia
    public function adminxxx() {
        require_once ROOT_PATH . 'app/views/auth/admin_register.php';
    }

    // 3. Process Register User (Inisiasi OTP)
    public function process_register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        $email    = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
        $password = trim($_POST['password'] ?? '');
        $instansi = trim(filter_input(INPUT_POST, 'instansi', FILTER_SANITIZE_SPECIAL_CHARS));

        // Validasi Kelengkapan Input
        if (empty($email) || empty($username) || empty($password) || empty($instansi)) {
            $_SESSION['error'] = 'Semua bidang input wajib diisi!';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        // Validasi Format Email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Format email tidak valid!';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        // Cek Keberadaan Email & Username
        if ($this->userModel->checkEmailExists($email)) {
            $_SESSION['error'] = 'Email sudah terdaftar!';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        if ($this->userModel->checkUsernameExists($username)) {
            $_SESSION['error'] = 'Username sudah terdaftar!';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        // Simpan Data Sementara di Session Sebelum Verifikasi
        $_SESSION['temp_user'] = [
            'email'    => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'instansi' => $instansi,
            'role'     => 'pelamar'
        ];

        // Generate & Simpan Kode OTP
        $otpCode = $this->userModel->generateOTP($email);

        // TODO: Kirim $otpCode ke $email menggunakan library mailer (seperti PHPMailer)
        // mail($email, "Kode OTP BKK DOSQLA", "Kode verifikasi Anda: $otpCode");

        header('Location: ' . BASE_URL . 'daftar/otp');
        exit;
    }

    // 4. Halaman Verifikasi OTP
    public function otp() {
        if (!isset($_SESSION['temp_user'])) {
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }
        require_once ROOT_PATH . 'app/views/auth/otp.php';
    }

    // 5. Process Verifikasi OTP
    public function process_otp() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'daftar/otp');
            exit;
        }

        if (!isset($_SESSION['temp_user'])) {
            $_SESSION['error'] = 'Sesi pendaftaran berakhir, silakan daftar ulang.';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        $inputOtp = trim($_POST['otp_code'] ?? '');
        $status   = $this->userModel->verifyOTP($inputOtp);

        if ($status === true) {
            // OTP Valid -> Simpan user ke Database Permanen
            $userData = $_SESSION['temp_user'];

            if ($this->userModel->register($userData)) {
                unset($_SESSION['temp_user']);
                $_SESSION['success'] = 'Verifikasi berhasil! Akun Anda telah aktif, silakan login.';
                header('Location: ' . BASE_URL . 'auth');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal menyimpan data akun, terjadi kesalahan sistem.';
                header('Location: ' . BASE_URL . 'daftar');
                exit;
            }
        } elseif ($status === 'expired') {
            $_SESSION['error'] = 'Kode OTP telah kedaluwarsa. Silakan minta kode baru.';
            header('Location: ' . BASE_URL . 'daftar/otp');
            exit;
        } else {
            $_SESSION['error'] = 'Kode OTP tidak cocok!';
            header('Location: ' . BASE_URL . 'daftar/otp');
            exit;
        }
    }

    // 6. Resend Kode OTP
    public function resend_otp() {
        if (!isset($_SESSION['temp_user'])) {
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        $email = $_SESSION['temp_user']['email'];
        $newOtp = $this->userModel->generateOTP($email);

        // TODO: Kirim ulang $newOtp ke $email via mailer

        $_SESSION['success'] = 'Kode OTP baru telah dikirimkan ke email Anda.';
        header('Location: ' . BASE_URL . 'daftar/otp');
        exit;
    }

    // 7. Process Register Admin
    public function process_admin_register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'auth/adminxxx');
            exit;
        }

        $email     = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $username  = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
        $password  = trim($_POST['password'] ?? '');
        $secretKey = trim($_POST['secret_key'] ?? '');

        $VALID_ADMIN_KEY = 'DOSQLA2026';

        if ($secretKey !== $VALID_ADMIN_KEY) {
            $_SESSION['error'] = 'Kode Rahasia Admin Salah!';
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

        if ($this->userModel->register($data)) {
            $_SESSION['success'] = 'Akun Admin Berhasil Dibuat! Silakan Login.';
            header('Location: ' . BASE_URL . 'auth');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal mendaftarkan Admin.';
            header('Location: ' . BASE_URL . 'auth/adminxxx');
            exit;
        }
    }
}