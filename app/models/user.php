<?php

class User {
    private $db;

    public function __construct() {
        // Memanggil class Database untuk mendapatkan koneksi PDO
        require_once ROOT_PATH . 'config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();
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