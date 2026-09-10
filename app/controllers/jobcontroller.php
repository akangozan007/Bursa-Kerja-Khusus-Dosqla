<?php
require_once ROOT_PATH . 'app/models/Job.php';

class JobController {
    private $jobModel;

    public function __construct() {
        $this->jobModel = new Job();
    }

    // Route: /job
    public function index() {
        $pageTitle = 'Daftar Lowongan Kerja - BKK DOSQLA';
        
        // Ambil seluruh data lowongan publik
        $jobs = $this->jobModel->getAllJobs();

        // Load Header Publik / Polos (Tanpa Proteksi Auth)
        require_once ROOT_PATH . 'app/views/header_public.php';
        require_once ROOT_PATH . 'app/views/jobs.php';
        require_once ROOT_PATH . 'app/views/ekstra/footer.php';
    }
}
?>