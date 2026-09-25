<?php
require_once ROOT_PATH . 'app/models/job.php';

class JobController {
    private $jobModel;

    public function __construct() {
        $this->jobModel = new Job();
    }

    // Route: /job (Bebas Akses)
    public function index() {
        $data['judul'] = 'Daftar Lowongan Kerja - BKK DOSQLA';
        $data['jobs']  = $this->jobModel->getAllJobs();

        // SELALU panggil header_public untuk area publik
        require_once ROOT_PATH . 'app/views/header_public.php';
        require_once ROOT_PATH . 'app/views/jobs.php';
        require_once ROOT_PATH . 'app/views/ekstra/footer.php';
    }
}