<?php
class Job {
    private $db;

    public function __construct() {
        // Hubungkan ke database bkk_db
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=bkk_db", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Koneksi gagal: " . $e->getMessage());
        }
    }

    public function getAllJobs() {
        $query = "SELECT * FROM lowongan ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // WAJIB mereturn array data
    }

    public function searchJobs($keyword) {
        $query = "SELECT * FROM lowongan WHERE judul LIKE :keyword OR perusahaan LIKE :keyword ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':keyword', '%' . $keyword . '%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>