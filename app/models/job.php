<?php
class Job {
    private $db;

    public function __construct($dbConnection = null) {
        if ($dbConnection) {
            $this->db = $dbConnection;
        } else {
            try {
                $this->db = new PDO("mysql:host=localhost;dbname=bkk_db;charset=utf8mb4", "root", "", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("Koneksi Database Gagal: " . $e->getMessage());
            }
        }
    }

    // Ambil semua data lowongan
    public function getAllJobs() {
        $stmt = $this->db->prepare("SELECT * FROM lowongan ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Ambil single lowongan berdasarkan ID
    public function getJobById($id) {
        $stmt = $this->db->prepare("SELECT * FROM lowongan WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Tambah lowongan baru
    public function createJob($data) {
        $sql = "INSERT INTO lowongan (judul, perusahaan, deskripsi) 
                VALUES (:judul, :perusahaan, :deskripsi)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':judul'      => $data['judul'] ?? $data['title'] ?? '',
            ':perusahaan' => $data['perusahaan'] ?? $data['company'] ?? '',
            ':deskripsi'  => $data['deskripsi'] ?? $data['description'] ?? null
        ]);
    }

    // Update lowongan
    public function updateJob($id, $data) {
        $sql = "UPDATE lowongan SET 
                    judul = :judul, 
                    perusahaan = :perusahaan, 
                    deskripsi = :deskripsi 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'         => $id,
            ':judul'      => $data['judul'] ?? $data['title'] ?? '',
            ':perusahaan' => $data['perusahaan'] ?? $data['company'] ?? '',
            ':deskripsi'  => $data['deskripsi'] ?? $data['description'] ?? null
        ]);
    }

    // Hapus lowongan
    public function deleteJob($id) {
        $stmt = $this->db->prepare("DELETE FROM lowongan WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>