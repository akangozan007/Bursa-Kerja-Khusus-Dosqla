<?php
require_once __DIR__ . '/../models/job.php';

class JobController {

    private $jobModel;

    public function __construct() {
        $this->jobModel = new Job();
    }

    // Menampilkan halaman utama pencarian lowongan
    public function index() {
        // Cek jika ada parameter pencarian 'q' di URL
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $keyword = trim($_GET['q']);
            $jobs = $this->jobModel->searchJobs($keyword);
        } else {
            $jobs = $this->jobModel->getAllJobs();
        }

        // Panggil view khusus halaman jobs
        require_once __DIR__ . '/../views/jobs/index.php';
    }

    // Menampilkan detail lowongan berdasarkan ID
    public function detail() {
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            $job = $this->jobModel->getJobById($id);
            require_once __DIR__ . '/../views/jobs/detail.php';
        } else {
            header('Location: ' . BASE_URL . 'jobs');
            exit;
        }
    }
}
?>