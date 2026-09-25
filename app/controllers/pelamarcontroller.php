<?php

class PelamarController {

    private $userModel;

    public function __construct() {
        require_once ROOT_PATH . 'app/models/user.php';
        require_once ROOT_PATH . 'app/helper/mail_helper.php';
        $this->userModel = new User();
    }

    /**
     * Helper privat untuk proteksi autentikasi pelamar
     */
    private function checkAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }

        if (isset($_SESSION['role']) && $_SESSION['role'] !== 'pelamar') {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
    }

    // -------------------------------------------------------------------------
    // AREA DASHBOARD INTERNAL (Menggunakan header.php / Internal Header)
    // -------------------------------------------------------------------------

    // Dashboard Pelamar (/pelamar)
    public function index() {
        $this->checkAuth();
        $allowedRole = 'pelamar';
        $pageTitle = 'Dashboard Pelamar - BKK DOSQLA';

        // Load Header Internal Pelamar
        require_once ROOT_PATH . 'app/views/ekstra/header.php';

        if (file_exists(ROOT_PATH . 'app/views/applicant/dashboard.php')) {
            require_once ROOT_PATH . 'app/views/applicant/dashboard.php';
        } else {
            echo "<div class='container py-4'><div class='alert alert-danger'>File view <strong>app/views/applicant/dashboard.php</strong> belum tersedia.</div></div>";
        }

        // Load Footer Internal (jika ada)
        if (file_exists(ROOT_PATH . 'app/views/ekstra/footer.php')) {
            require_once ROOT_PATH . 'app/views/ekstra/footer.php';
        }
    }

  // Halaman Portal Lowongan Khusus Pelamar (/pelamar/job)
    public function job() {
        $this->checkAuth();
        $allowedRole = 'pelamar';
        $pageTitle = 'Portal Lowongan Kerja Pelamar';

        require_once ROOT_PATH . 'app/models/job.php';
        $jobModel = new Job();

        $data['judul'] = $pageTitle;
        $data['jobs']  = method_exists($jobModel, 'getAllJobs') ? $jobModel->getAllJobs() : [];

        // Load Header Internal Dashboard
        require_once ROOT_PATH . 'app/views/ekstra/header.php';

        // Prioritaskan pemanggilan file applicant_jobs.php
        if (file_exists(ROOT_PATH . 'app/views/applicant/applicant_jobs.php')) {
            require_once ROOT_PATH . 'app/views/applicant/applicant_jobs.php';
        } elseif (file_exists(ROOT_PATH . 'app/views/applicant/jobs.php')) {
            require_once ROOT_PATH . 'app/views/applicant/jobs.php';
        } else {
            echo "<div class='container py-4'><div class='alert alert-danger'>File view lowongan pelamar belum tersedia.</div></div>";
        }

        // Load Footer Internal (opsional)
        if (file_exists(ROOT_PATH . 'app/views/ekstra/footer.php')) {
            require_once ROOT_PATH . 'app/views/ekstra/footer.php';
        }
    }

    // Halaman Profil Pelamar & Update Data (/pelamar/profile)
    public function profile() {
        $this->checkAuth();
        $allowedRole = 'pelamar';
        $pageTitle = 'Profil Saya - BKK DOSQLA';

        $userId = $_SESSION['user_id'];

        // Proses Update Profil jika Form di-submit (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updateData = [
                'user_id'             => $userId,
                'nama_lengkap'        => trim(filter_input(INPUT_POST, 'nama_lengkap', FILTER_SANITIZE_SPECIAL_CHARS)),
                'no_telepon'          => trim(filter_input(INPUT_POST, 'no_telepon', FILTER_SANITIZE_SPECIAL_CHARS)),
                'alamat'              => trim(filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_SPECIAL_CHARS)),
                'pendidikan_terakhir' => trim(filter_input(INPUT_POST, 'pendidikan_terakhir', FILTER_SANITIZE_SPECIAL_CHARS))
            ];

            if (method_exists($this->userModel, 'updateProfile') && $this->userModel->updateProfile($updateData)) {
                $_SESSION['success'] = 'Profil berhasil diperbarui!';
            } else {
                $_SESSION['error'] = 'Gagal memperbarui profil.';
            }

            header('Location: ' . BASE_URL . 'pelamar/profile');
            exit;
        }

        $pelamarData = method_exists($this->userModel, 'getProfileByUserId') 
            ? $this->userModel->getProfileByUserId($userId) 
            : [];

        // Load Header Internal Pelamar
        require_once ROOT_PATH . 'app/views/ekstra/header.php';

        if (file_exists(ROOT_PATH . 'app/views/applicant/profile.php')) {
            require_once ROOT_PATH . 'app/views/applicant/profile.php';
        } elseif (file_exists(ROOT_PATH . 'app/views/pelamar/profile.php')) {
            require_once ROOT_PATH . 'app/views/pelamar/profile.php';
        } else {
            echo "<div class='container py-4'><div class='alert alert-danger'>File view <strong>profile.php</strong> belum tersedia.</div></div>";
        }

        if (file_exists(ROOT_PATH . 'app/views/ekstra/footer.php')) {
            require_once ROOT_PATH . 'app/views/ekstra/footer.php';
        }
    }


    // -------------------------------------------------------------------------
    // AREA REGISTRASI & AUTH PUBLIK (Menggunakan header_public.php)
    // -------------------------------------------------------------------------

    // Tampilkan Form Registrasi Pelamar (/pelamar/daftar)
    public function daftar() {
        $data['title'] = 'Pendaftaran Pelamar - BKK DOSQLA';

        // Load Header Publik untuk Tamu
        require_once ROOT_PATH . 'app/views/header_public.php';
        require_once ROOT_PATH . 'app/views/auth/daftar.php';
        if (file_exists(ROOT_PATH . 'app/views/ekstra/footer.php')) {
            require_once ROOT_PATH . 'app/views/ekstra/footer.php';
        }
    }

    // Proses Form Registrasi Pelamar
    public function process_register() { 
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'pelamar/daftar');
            exit;
        }

        $email    = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
        $password = trim($_POST['password'] ?? '');
        $instansi = trim(filter_input(INPUT_POST, 'instansi', FILTER_SANITIZE_SPECIAL_CHARS));

        if (empty($email) || empty($username) || empty($password) || empty($instansi)) {
            $_SESSION['error'] = 'Semua bidang input wajib diisi!';
            header('Location: ' . BASE_URL . 'pelamar/daftar');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Format email tidak valid!';
            header('Location: ' . BASE_URL . 'pelamar/daftar');
            exit;
        }

        if ($this->userModel->checkEmailExists($email)) {
            $_SESSION['error'] = 'Email sudah terdaftar!';
            header('Location: ' . BASE_URL . 'pelamar/daftar');
            exit;
        }

        if ($this->userModel->checkUsernameExists($username)) {
            $_SESSION['error'] = 'Username sudah terdaftar!';
            header('Location: ' . BASE_URL . 'pelamar/daftar');
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

        header('Location: ' . BASE_URL . 'pelamar/otp');
        exit;
    }

    // Halaman Form Input OTP (/pelamar/otp)
    public function otp() {
        if (!isset($_SESSION['temp_user'])) {
            header('Location: ' . BASE_URL . 'pelamar/daftar');
            exit;
        }

        $data['title'] = 'Verifikasi Kode OTP - BKK DOSQLA';

        // Load Header Publik untuk OTP
        require_once ROOT_PATH . 'app/views/header_public.php';
        require_once ROOT_PATH . 'app/views/auth/otp.php';
        if (file_exists(ROOT_PATH . 'app/views/ekstra/footer.php')) {
            require_once ROOT_PATH . 'app/views/ekstra/footer.php';
        }
    }

    // Eksekusi Verifikasi OTP
    public function process_otp() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'pelamar/otp');
            exit;
        }

        if (!isset($_SESSION['temp_user'])) {
            $_SESSION['error'] = 'Sesi pendaftaran berakhir, silakan daftar ulang.';
            header('Location: ' . BASE_URL . 'pelamar/daftar');
            exit;
        }

        if (!isset($_SESSION['otp_data'])) {
            $_SESSION['error'] = 'Kode OTP tidak ditemukan atau telah kadaluwarsa.';
            header('Location: ' . BASE_URL . 'pelamar/daftar');
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
                header('Location: ' . BASE_URL . 'pelamar/daftar');
                exit;
            }
        } elseif ($status === 'expired') {
            $_SESSION['error'] = 'Kode OTP telah kedaluwarsa. Silakan lakukan pendaftaran ulang.';
            header('Location: ' . BASE_URL . 'pelamar/daftar');
            exit;
        } else {
            $_SESSION['error'] = 'Kode OTP tidak cocok!';
            header('Location: ' . BASE_URL . 'pelamar/otp');
            exit;
        }
    }

    // Kirim Ulang OTP
    public function resend_otp() {
        if (!isset($_SESSION['temp_user'])) {
            header('Location: ' . BASE_URL . 'pelamar/daftar');
            exit;
        }

        $email = $_SESSION['temp_user']['email'];
        $newOtp = $this->userModel->generateOTP($email);
        sendOtpEmail($email, $newOtp);

        $_SESSION['success'] = 'Kode OTP baru telah dikirimkan ke email Anda.';
        header('Location: ' . BASE_URL . 'pelamar/otp');
        exit;
    }
}