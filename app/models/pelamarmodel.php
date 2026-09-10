<?php
class PelamarModel {
    private $db;

    public function __construct() {
        // Inisialisasi koneksi DB (sesuaikan dengan mekanisme DB Anda)
        $this->db = new Database(); 
    }

    public function getProfileByUserId($userId) {
        $this->db->query("SELECT * FROM pelamar WHERE user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    public function updateProfile($data) {
        $query = "UPDATE pelamar SET 
                    nama_lengkap = :nama_lengkap, 
                    no_telepon = :no_telepon, 
                    alamat = :alamat, 
                    pendidikan_terakhir = :pendidikan_terakhir 
                  WHERE user_id = :user_id";

        $this->db->query($query);
        $this->db->bind(':nama_lengkap', $data['nama_lengkap']);
        $this->db->bind(':no_telepon', $data['no_telepon']);
        $this->db->bind(':alamat', $data['alamat']);
        $this->db->bind(':pendidikan_terakhir', $data['pendidikan_terakhir']);
        $this->db->bind(':user_id', $data['user_id']);

        return $this->db->execute();
    }
}