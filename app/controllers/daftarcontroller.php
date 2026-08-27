<?php

class DaftarController {

    private $userModel;

    public function __construct() {
        require_once ROOT_PATH . 'app/models/User.php';
        $this->userModel = new User();
    }

    public function index() {
        require_once ROOT_PATH . 'app/views/auth/daftar.php';
    }

    public function process_register() {
        // --- DEBUGGER STEP 1: Cek apakah method POST masuk ---
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die('[DEBUG 1] Request bukan method POST!');
        }

        // --- DEBUGGER STEP 2: Cek data mentah dari form ---
        // Un-comment baris di bawah jika ingin melihat isi $_POST langsung
        // var_dump($_POST); die();

        $email    = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
        $password = trim($_POST['password'] ?? '');
        $instansi = trim(filter_input(INPUT_POST, 'instansi', FILTER_SANITIZE_SPECIAL_CHARS));

        // --- DEBUGGER STEP 3: Validasi input kosong ---
        if (empty($email) || empty($username) || empty($password) || empty($instansi)) {
            die('[DEBUG 3] Ada input yang kosong. Email: '.$email.', User: '.$username.', Instansi: '.$instansi);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('[DEBUG 3.1] Format Email tidak valid!');
        }

        // --- DEBUGGER STEP 4: Cek duplikasi di Database ---
        if ($this->userModel->checkEmailExists($email)) {
            die('[DEBUG 4] Email sudah terdaftar di database!');
        }

        if ($this->userModel->checkUsernameExists($username)) {
            die('[DEBUG 4] Username sudah terdaftar di database!');
        }

        // Hash Password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'email'    => $email,
            'username' => $username,
            'password' => $hashedPassword,
            'instansi' => $instansi,
            'role'     => 'pelamar'
        ];

        // --- DEBUGGER STEP 5: Eksekusi Insert & Tangkap PDO Error ---
        try {
            $isInserted = $this->userModel->register($data);
            if ($isInserted) {
                die('[DEBUG SUCCESS] Data BERHASIL masuk ke database!');
            } else {
                die('[DEBUG FAILED] Query jalan tapi gagal insert (execute returns false).');
            }
        } catch (PDOException $e) {
            die('[DEBUG PDO ERROR] Exception caught: ' . $e->getMessage());
        }
    }
}