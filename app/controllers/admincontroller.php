<?php

class AdminController {

    private $userModel;
    private $jobModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Keamanan: Cek Session Login & Role Admin untuk aksi internal
        $action = $_GET['url'] ?? '';
        $isRegisterAction = strpos($action, 'send_admin_otp') !== false || 
                            strpos($action, 'verify_admin_otp') !== false || 
                            strpos($action, 'resend_admin_otp') !== false || 
                            strpos($action, 'adminxxx') !== false;

        if (!$isRegisterAction) {
            if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_admin'])) {
                header('Location: ' . BASE_URL . 'login');
                exit;
            }
        }

        require_once ROOT_PATH . 'app/models/user.php';
        require_once ROOT_PATH . 'app/models/job.php';
        require_once ROOT_PATH . 'app/helper/mail_helper.php';

        $this->userModel = new User();
        $this->jobModel  = new Job();
    }

    // ==========================================
    // DASHBOARD & UTAMA
    // ==========================================

    public function index() {
        $allowedRole = 'admin';
        $pageTitle   = 'Dashboard Admin - BKK DOSQLA';

        // Fetch Data dari Model
        $jobs        = method_exists($this->jobModel, 'getAllJobs') ? $this->jobModel->getAllJobs() : [];
        $applicants  = method_exists($this->jobModel, 'getAllApplicants') ? $this->jobModel->getAllApplicants() : [];
        $users       = method_exists($this->userModel, 'getAllUsers') ? $this->userModel->getAllUsers() : [];
        $recentApps  = method_exists($this->jobModel, 'getRecentApplications') ? $this->jobModel->getRecentApplications() : [];

        $data = [
            'total_jobs_active'      => count($jobs),
            'total_applicants'       => count($applicants),
            'total_alumni_placed'    => method_exists($this->jobModel, 'getHiredCount') ? $this->jobModel->getHiredCount() : 0,
            'total_registered_users' => count($users),
            'recent_applications'    => $recentApps,
            'jobs_list'              => $jobs,
            'all_applicants'         => $applicants,
            'users_list'             => $users
        ];

        require_once ROOT_PATH . 'app/views/admin/dashboard.php';
    }

    // Form Khusus Registrasi Admin (/admin/adminxxx atau /auth/adminxxx)
    public function adminxxx() {
        require_once ROOT_PATH . 'app/views/auth/admin_register.php';
    }

    // ==========================================
    // HALAMAN & MANAJEMEN PELAMAR
    // ==========================================

    // Route: /admin/kelola-pelamar
    public function kelolaPelamar() {
        $allowedRole = 'admin';
        $pageTitle   = 'Kelola Pelamar & Lamaran - BKK DOSQLA';

        // Ambil daftar pelamar dari model
        $applicants = method_exists($this->jobModel, 'getAllApplicants') 
            ? $this->jobModel->getAllApplicants() 
            : [];

        // Load Views
        require_once ROOT_PATH . 'app/views/ekstra/header.php';
        require_once ROOT_PATH . 'app/views/admin/kelola_pelamar.php';
        require_once ROOT_PATH . 'app/views/ekstra/footer.php';
    }

    // Action Handler: /admin/update-status-pelamar (Form POST & AJAX)
    public function updateStatusPelamar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_lamaran = filter_input(INPUT_POST, 'id_lamaran', FILTER_VALIDATE_INT) 
                       ?? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $status     = trim($_POST['status'] ?? '');

            if ($id_lamaran && !empty($status)) {
                $updated = false;

                if (method_exists($this->jobModel, 'updateApplicantStatus')) {
                    $updated = $this->jobModel->updateApplicantStatus($id_lamaran, $status);
                } elseif (method_exists($this->jobModel, 'updateApplicationStatus')) {
                    $updated = $this->jobModel->updateApplicationStatus($id_lamaran, $status);
                }

                if ($updated) {
                    $_SESSION['success'] = "Status lamaran berhasil diperbarui!";
                } else {
                    $_SESSION['error'] = "Gagal memperbarui status lamaran di database.";
                }
            } else {
                $_SESSION['error'] = "Data status atau ID lamaran tidak valid.";
            }
        }

        // Respon JSON jika dipanggil via AJAX
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            if (ob_get_length()) ob_clean();
            header('Content-Type: application/json');
            echo json_encode([
                'status'  => isset($_SESSION['success']) ? 'success' : 'error',
                'message' => $_SESSION['success'] ?? $_SESSION['error']
            ]);
            unset($_SESSION['success'], $_SESSION['error']);
            exit;
        }

        header("Location: " . BASE_URL . "admin/kelola-pelamar");
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

        $otpCode  = $this->userModel->generateOTP($email);
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
        $status   = $this->userModel->verifyOTP($inputOtp);

        if ($status === true) {
            $adminData = $_SESSION['temp_admin'];

            if ($this->userModel->register($adminData)) {
                $_SESSION['role']       = 'admin';
                $_SESSION['username']   = $adminData['username'];
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

        $email    = $_SESSION['temp_admin']['email'];
        $newOtp   = $this->userModel->generateOTP($email);
        $mailSent = sendOtpEmail($email, $newOtp);

        if ($mailSent) {
            echo json_encode(['status' => 'success', 'message' => 'Kode OTP baru telah dikirimkan.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim ulang email OTP.']);
        }
        exit;
    }

    // ==========================================
    // MANAJEMEN LOWONGAN (CRUD JOB)
    // ==========================================

    public function save_job() {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Method tidak diizinkan.']);
            exit;
        }

        $id             = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $title          = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
        $company        = trim(filter_input(INPUT_POST, 'company', FILTER_SANITIZE_SPECIAL_CHARS));
        $description    = trim($_POST['description'] ?? '');
        $qualifications = trim($_POST['qualifications'] ?? '');
        $open_date      = trim($_POST['open_date'] ?? '');
        $close_date     = trim($_POST['close_date'] ?? '');
        $status         = trim($_POST['status'] ?? 'open');

        if (empty($title) || empty($company)) {
            echo json_encode(['status' => 'error', 'message' => 'Judul dan nama perusahaan wajib diisi!']);
            exit;
        }

        $jobData = [
            'title'          => $title,
            'company'        => $company,
            'description'    => $description,
            'qualifications' => $qualifications,
            'open_date'      => $open_date,
            'close_date'     => $close_date,
            'status'         => $status
        ];

        if ($id) {
            $result = $this->jobModel->updateJob($id, $jobData);
            $msg    = 'Lowongan berhasil diperbarui!';
        } else {
            $result = $this->jobModel->createJob($jobData);
            $msg    = 'Lowongan baru berhasil ditambahkan!';
        }

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => $msg]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data lowongan ke database.']);
        }
        exit;
    }

    public function delete_job() {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID Lowongan tidak valid.']);
            exit;
        }

        if ($this->jobModel->deleteJob($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Lowongan berhasil dihapus.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus lowongan.']);
        }
        exit;
    }

    // ==========================================
    // MANAJEMEN USER & ALUMNI
    // ==========================================

    public function toggle_user_status() {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        $user_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $status  = trim($_POST['status'] ?? ''); 

        if (!$user_id || !in_array($status, ['active', 'blocked'])) {
            echo json_encode(['status' => 'error', 'message' => 'Data user tidak valid.']);
            exit;
        }

        if ($this->userModel->updateUserStatus($user_id, $status)) {
            echo json_encode(['status' => 'success', 'message' => 'Status akses user berhasil diubah.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate status user.']);
        }
        exit;
    }

    public function reset_user_password() {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        $user_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'ID User tidak valid.']);
            exit;
        }

        $defaultPassword = password_hash('12345678', PASSWORD_BCRYPT);
        if ($this->userModel->resetPassword($user_id, $defaultPassword)) {
            echo json_encode(['status' => 'success', 'message' => 'Password berhasil di-reset menjadi: 12345678']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mereset password.']);
        }
        exit;
    }
}