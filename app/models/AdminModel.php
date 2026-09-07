<?php
class AdminModel {
    private $db;

    public function __construct() {
        // Koneksi ke Database bkk_db
        $this->db = new PDO("mysql:host=localhost;dbname=bkk_db", "root", "");
    }

    // --- DASHBOARD STATS ---
    public function getDashboardStats() {
        $stats = [];
        $stats['total_jobs_active']      = $this->db->query("SELECT COUNT(*) FROM lowongan")->fetchColumn();
        $stats['total_applicants']       = $this->db->query("SELECT COUNT(*) FROM applications")->fetchColumn();
        $stats['total_alumni_placed']    = $this->db->query("SELECT COUNT(*) FROM applications WHERE status = 'lolos'")->fetchColumn();
        $stats['total_registered_users'] = $this->db->query("SELECT COUNT(*) FROM users WHERE role = 'pelamar'")->fetchColumn();
        return $stats;
    }

    // --- MANAJEMEN LOWONGAN (Sesuai Tabel `lowongan`) ---
    public function getAllJobs() {
        // Alias disesuaikan agar cocok dengan $job['judul'], $job['kategori'], $job['tanggal_tutup'] pada dashboard.php
        $sql = "SELECT 
                    id, 
                    judul, 
                    perusahaan AS kategori, 
                    'Full Time' AS tipe, 
                    created_at AS tanggal_tutup, 
                    'open' AS status 
                FROM lowongan 
                ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createJob($data) {
        $stmt = $this->db->prepare("INSERT INTO lowongan (judul, deskripsi, perusahaan) VALUES (?, ?, ?)");
        return $stmt->execute([
            $data['judul'], 
            $data['deskripsi'] ?? '', 
            $data['perusahaan']
        ]);
    }

    public function updateJob($id, $data) {
        $stmt = $this->db->prepare("UPDATE lowongan SET judul = ?, deskripsi = ?, perusahaan = ? WHERE id = ?");
        return $stmt->execute([
            $data['judul'], 
            $data['deskripsi'] ?? '', 
            $data['perusahaan'], 
            $id
        ]);
    }

    public function deleteJob($id) {
        $stmt = $this->db->prepare("DELETE FROM lowongan WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // --- MANAJEMEN PELAMAR & BERKAS ---
    public function getRecentApplications($limit = 5) {
        $sql = "SELECT 
                    a.id AS id_lamaran, 
                    a.applied_at AS created_at, 
                    u.username AS nama_lengkap, 
                    l.judul AS judul_lowongan, 
                    a.status 
                FROM applications a 
                JOIN users u ON a.user_id = u.id 
                JOIN lowongan l ON a.job_id = l.id 
                ORDER BY a.id DESC 
                LIMIT " . (int)$limit;
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllApplicants() {
        $sql = "SELECT 
                    a.id AS id_lamaran, 
                    u.id AS id_user, 
                    u.username AS nama_lengkap, 
                    l.judul AS judul_lowongan, 
                    a.cv_file AS file_cv, 
                    a.status 
                FROM applications a 
                JOIN users u ON a.user_id = u.id 
                JOIN lowongan l ON a.job_id = l.id 
                ORDER BY a.id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateApplicationStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE applications SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    // --- MANAJEMEN USER / ALUMNI ---
    public function getAllUsers() {
        $sql = "SELECT 
                    id, 
                    username, 
                    email, 
                    IF(status = 'active', 1, 0) AS status_aktif 
                FROM users 
                WHERE role = 'pelamar' 
                ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toggleUserStatus($id) {
        $stmt = $this->db->prepare("UPDATE users SET status = IF(status = 'active', 'blocked', 'active') WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function resetUserPassword($id, $hashedPassword) {
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashedPassword, $id]);
    }
}