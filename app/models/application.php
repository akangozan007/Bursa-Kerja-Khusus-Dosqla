<?php

class Application {
    private $db;

    public function __construct() {
        // Asumsi class Database sudah ada di config/database.php
        $this->db = new Database(); 
    }

    // Fungsi kirim lamaran baru oleh pelamar
    public function createApplication($userId, $jobId, $cvFileName) {
        $query = "INSERT INTO applications (user_id, job_id, cv_file, status, applied_at) 
                  VALUES (:user_id, :job_id, :cv_file, 'Proses', NOW())";
        $this->db->query($query);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':job_id', $jobId);
        $this->db->bind(':cv_file', $cvFileName);
        return $this->db->execute();
    }

    // Ambil riwayat lamaran khusus user/pelamar tertentu
    public function getApplicationsByUser($userId) {
        $query = "SELECT applications.*, jobs.title, jobs.company 
                  FROM applications 
                  JOIN jobs ON applications.job_id = jobs.id 
                  WHERE applications.user_id = :user_id 
                  ORDER BY applications.applied_at DESC";
        $this->db->query($query);
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
}