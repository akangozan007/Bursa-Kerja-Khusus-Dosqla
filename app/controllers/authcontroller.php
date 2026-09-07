<?php

class AuthController {

    private $userModel;
    private $jobModel;

    public function __construct() {
        require_once ROOT_PATH . 'app/models/user.php';
        require_once ROOT_PATH . 'app/models/job.php';

        $this->userModel = new User();
        $this->jobModel  = new Job();
    }

    // Halaman Utam / Landing Page Publik
    public function home() {
        $jobs = $this->jobModel->getAllJobs();

        $data = [
            'title' => 'BKK DOSQLA - SMK Muhammadiyah Lemahabang',
            'jobs'  => $jobs
        ];

        require_once ROOT_PATH . 'app/views/home.php';
    }

    // Pencarian & Daftar Lowongan Publik (/auth/jobs)
    public function jobs() {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (!empty($keyword)) {
            $jobs = $this->jobModel->searchJobs($keyword);
        } else {
            $jobs = $this->jobModel->getAllJobs();
        }

        require_once ROOT_PATH . 'app/views/jobs/index.php';
    }

    // Halaman Form Login Publik
    public function index() {
        if ($this->isLoggedIn()) {
            $this->redirectBasedOnRole();
            exit;
        }

        require_once ROOT_PATH . 'app/views/auth/login.php';
    }

    // Eksekusi Login
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

        $user = $this->userModel->login($emailOrUsername, $password);

        if ($user) {
            if (isset($user['status_aktif']) && $user['status_aktif'] == 0) {
                $_SESSION['error'] = 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.';
                header('Location: ' . BASE_URL . 'auth');
                exit;
            }

            $role = strtolower($user['role']);

            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['email']     = $user['email'];
            $_SESSION['role']      = $role; 

            if ($role === 'admin') {
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
                    'role'     => $role
                ];
            }

            $this->redirectBasedOnRole();
            exit;

        } else {
            $_SESSION['error'] = 'Username/Email atau Password salah!';
            header('Location: ' . BASE_URL . 'auth');
            exit;
        }
    }

    // Proses Logout
    public function logout() {
        $_SESSION = array();

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

        session_destroy();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['success'] = 'Anda telah berhasil keluar.';
        header('Location: ' . BASE_URL . 'auth');
        exit;
    }

    private function redirectBasedOnRole() {
        $role = $_SESSION['role'] ?? '';

        if ($role === 'admin') {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        } elseif ($role === 'pelamar' || $role === 'applicant') {
            header('Location: ' . BASE_URL . 'pelamar');
            exit;
        } else {
            header('Location: ' . BASE_URL);
            exit;
        }
    }

    private function isLoggedIn() {
        return isset($_SESSION['user_id']) && isset($_SESSION['role']);
    }
}