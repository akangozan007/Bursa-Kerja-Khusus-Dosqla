<?php
class HomeController {

    public function index() {
        // Ambil data jika diperlukan dari Model
        $jobModel = new Job();
        $jobs = $jobModel->getAllJobs();

        // Oper data ke View Landing Page
        $data = [
            'title' => 'BKK DOSQLA - SMK Muhammadiyah Lemahabang',
            'jobs'  => $jobs
        ];

        // Load View
        require_once 'app/views/home.php';
    }
}