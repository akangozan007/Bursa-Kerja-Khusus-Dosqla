<?php

class User {
    private $db;

    public function __construct() {
        // Memanggil class Database untuk mendapatkan koneksi PDO
        require_once ROOT_PATH . 'config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Buat/simpan OTP ke session (atau database jika ada kolom otp)
    public function generateOTP($email) {
        $otp = rand(100000, 999999);
        $_SESSION['otp_data'] = [
            'email' => $email,
            'code' => $otp,
            'expires' => time() + (5 * 60) // Berlaku 5 menit
        ];
        return $otp;
    }

    public function verifyOTP($inputOtp) {
        if (!isset($_SESSION['otp_data'])) {
            return false;
        }

        $otpData = $_SESSION['otp_data'];
        
        if (time() > $otpData['expires']) {
            unset($_SESSION['otp_data']);
            return 'expired';
        }

        if ($otpData['code'] == $inputOtp) {
            unset($_SESSION['otp_data']);
            return true;
        }

        return false;
    }

    // Cek apakah Email sudah terdaftar (PDO)
    public function checkEmailExists($email) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Cek apakah Username sudah digunakan (PDO)
    public function checkUsernameExists($username) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Insert data user baru ke tabel users (PDO)
    public function register($data) {
        $query = "INSERT INTO users (email, username, password, instansi, role) 
                  VALUES (:email, :username, :password, :instansi, :role)";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':instansi', $data['instansi']);
        $stmt->bindParam(':role', $data['role']);

        return $stmt->execute();
    }
}