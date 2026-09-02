<?php
class Job {
    private $db;

    public function __construct() {
        // Sesuaikan dengan koneksi PDO proyek Anda
        $this->db = new PDO("mysql:host=localhost;dbname=bkk_db", "root", "");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllJobs() {
        $query = "SELECT * FROM lowongan ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchJobs($keyword) {
        $query = "SELECT * FROM lowongan WHERE judul LIKE :keyword OR perusahaan LIKE :keyword ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':keyword', '%' . $keyword . '%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJobById($id) {
        $query = "SELECT * FROM lowongan WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>