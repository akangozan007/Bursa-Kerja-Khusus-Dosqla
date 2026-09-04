<?php

class DaftarController {

    private $userModel;

    public function __construct() {
        require_once ROOT_PATH . 'app/models/user.php';
        require_once ROOT_PATH . 'app/helper/mail_helper.php';
        
        $this->userModel = new User();
    }

    // 1. Form Register User/Pelamar
    public function index() {
        require_once ROOT_PATH . 'app/views/auth/daftar.php';
    }

    // 2. Form Register Admin
    public function adminxxx() {
        require_once ROOT_PATH . 'app/views/auth/admin_register.php';
    }

    // ==========================================
    // ALUR REGISTRASI PELAMAR (PAGE BASED OTP)
    // ==========================================

    public function process_register() { 
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        $email    = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
        $password = trim($_POST['password'] ?? '');
        $instansi = trim(filter_input(INPUT_POST, 'instansi', FILTER_SANITIZE_SPECIAL_CHARS));

        if (empty($email) || empty($username) || empty($password) || empty($instansi)) {
            $_SESSION['error'] = 'Semua bidang input wajib diisi!';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Format email tidak valid!';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

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

        $_SESSION['temp_user'] = [
            'email'    => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'instansi' => $instansi,
            'role'     => 'pelamar'
        ];

        $otpCode = $this->userModel->generateOTP($email);
        sendOtpEmail($email, $otpCode);

        header('Location: ' . BASE_URL . 'daftar/otp');
        exit;
    }

    public function otp() {
        if (!isset($_SESSION['temp_user'])) {
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }
        require_once ROOT_PATH . 'app/views/auth/otp.php';
    }

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

        if (!isset($_SESSION['otp_data'])) {
            $_SESSION['error'] = 'Kode OTP tidak ditemukan atau telah kadaluwarsa, silakan daftar ulang.';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        $inputOtp = trim($_POST['otp_code'] ?? '');
        $status = $this->userModel->verifyOTP($inputOtp);

        if ($status === true) {
            $userData = $_SESSION['temp_user'];

            if ($this->userModel->register($userData)) {
                unset($_SESSION['temp_user']);
                unset($_SESSION['otp_data']);

                $_SESSION['success'] = 'Verifikasi berhasil! Akun Anda telah aktif, silakan login.';
                header('Location: ' . BASE_URL . 'auth');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal menyimpan data akun, terjadi kesalahan sistem.';
                header('Location: ' . BASE_URL . 'daftar');
                exit;
            }
        } elseif ($status === 'expired') {
            $_SESSION['error'] = 'Kode OTP telah kedaluwarsa. Silakan lakukan pendaftaran ulang.';
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        } else {
            $_SESSION['error'] = 'Kode OTP tidak cocok!';
            header('Location: ' . BASE_URL . 'daftar/otp');
            exit;
        }
    }

    public function resend_otp() {
        if (!isset($_SESSION['temp_user'])) {
            header('Location: ' . BASE_URL . 'daftar');
            exit;
        }

        $email = $_SESSION['temp_user']['email'];
        $newOtp = $this->userModel->generateOTP($email);
        sendOtpEmail($email, $newOtp);

        $_SESSION['success'] = 'Kode OTP baru telah dikirimkan ke email Anda.';
        header('Location: ' . BASE_URL . 'daftar/otp');
        exit;
    }

    // ==========================================
    // ALUR REGISTRASI ADMIN (AJAX MODAL OTP)
    // ==========================================

    public function send_admin_otp() {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Method tidak diizinkan.']);
            exit;
        }

        $email    = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($username) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Semua bidang wajib diisi!']);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Format email tidak valid!']);
            exit;
        }

        if ($this->userModel->checkEmailExists($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Email sudah terdaftar!']);
            exit;
        }

        if ($this->userModel->checkUsernameExists($username)) {
            echo json_encode(['status' => 'error', 'message' => 'Username sudah terdaftar!']);
            exit;
        }

        $_SESSION['temp_admin'] = [
            'email'    => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'instansi' => 'Pengelola BKK',
            'role'     => 'admin'
        ];

        $otpCode = $this->userModel->generateOTP($email);
        $mailSent = sendOtpEmail($email, $otpCode);

        if ($mailSent) {
            echo json_encode(['status' => 'success', 'message' => 'Kode OTP berhasil dikirim.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim email OTP. Periksa server SMTP.']);
        }
        exit;
    }

    public function verify_admin_otp() {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Method tidak diizinkan.']);
            exit;
        }

        if (!isset($_SESSION['temp_admin'])) {
            echo json_encode(['status' => 'error', 'message' => 'Sesi pendaftaran tidak ditemukan. Silakan isi ulang form.']);
            exit;
        }

        $inputOtp = trim($_POST['otp_code'] ?? '');
        $status = $this->userModel->verifyOTP($inputOtp);

        if ($status === true) {
            $adminData = $_SESSION['temp_admin'];

            if ($this->userModel->register($adminData)) {
                
                // Set Session Admin
                $_SESSION['role'] = 'admin';
                $_SESSION['username'] = $adminData['username'];
                $_SESSION['user_admin'] = [
                    'username' => $adminData['username'],
                    'email'    => $adminData['email'],
                    'role'     => 'admin'
                ];

                unset($_SESSION['temp_admin']);
                unset($_SESSION['otp_data']);

                echo json_encode([
                    'status'   => 'success', 
                    'message'  => 'Verifikasi berhasil! Mengalihkan ke Dashboard Admin...',
                    'redirect' => BASE_URL . 'admin/'
                ]);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data Admin ke database.']);
                exit;
            }
        } elseif ($status === 'expired') {
            echo json_encode(['status' => 'error', 'message' => 'Kode OTP telah kedaluwarsa.']);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Kode OTP yang Anda masukkan salah!']);
            exit;
        }
    } // <-- PASTIKAN KURUNG KURAWAL PENUTUP METHOD verify_admin_otp() INI ADA!

    public function resend_admin_otp() {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        if (!isset($_SESSION['temp_admin'])) {
            echo json_encode(['status' => 'error', 'message' => 'Sesi pendaftaran berakhir.']);
            exit;
        }

        $email = $_SESSION['temp_admin']['email'];
        $newOtp = $this->userModel->generateOTP($email);
        $mailSent = sendOtpEmail($email, $newOtp);

        if ($mailSent) {
            echo json_encode(['status' => 'success', 'message' => 'Kode OTP baru telah dikirimkan.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim ulang email OTP.']);
        }
        exit;
    }
} // <-- Kurung kurawal penutup class