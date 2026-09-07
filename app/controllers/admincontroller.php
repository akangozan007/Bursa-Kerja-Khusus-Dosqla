<?php

class AdminController {

    private $userModel;
    private $jobModel;

    public function __construct() {
        // Keamanan: Cek Session Login & Role Admin untuk aksi internal
        // (Diabaikan hanya untuk method pendaftaran admin)
        $action = $_GET['url'] ?? '';
        $isRegisterAction = strpos($action, 'send_admin_otp') !== false || 
                            strpos($action, 'verify_admin_otp') !== false || 
                            strpos($action, 'resend_admin_otp') !== false || 
                            strpos($action, 'adminxxx') !== false;

        if (!$isRegisterAction) {
            if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
                header('Location: ' . BASE_URL . 'auth');
                exit;
            }
        }

        require_once ROOT_PATH . 'app/models/user.php';
        require_once ROOT_PATH . 'app/models/job.php';
        require_once ROOT_PATH . 'app/helper/mail_helper.php';

        $this->userModel = new User();
        $this->jobModel  = new Job();
    }

    // Menampilkan Halaman Dashboard Panel Admin
    public function index() {
        $data = [
            'jobs'       => $this->jobModel->getAllJobs(),
            'total_jobs' => count($this->jobModel->getAllJobs()),
        ];

        require_once ROOT_PATH . 'app/views/admin.php';
    }

    // Form Khusus Registrasi Admin (/admin/adminxxx atau /auth/adminxxx)
    public function adminxxx() {
        require_once ROOT_PATH . 'app/views/auth/admin_register.php';
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
                    'redirect' => BASE_URL . 'admin'
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
    }

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

    // CRUD Lowongan Pekerjaan
    public function create_job() {
        // Fitur tambah lowongan admin
    }

    public function update_status_pelamar() {
        // Fitur update status lamaran
    }
}