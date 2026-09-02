<?php
class JobController {

    private $jobModel;

    public function __construct() {
        // Memanggil model Job (autoloading di index.php sudah menangani require file-nya)
        $this->jobModel = new Job();
    }

    public function index() {
        // Ambil kata kunci dari $_GET['q']
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (!empty($keyword)) {
            $jobs = $this->jobModel->searchJobs($keyword);
        } else {
            // Ambil semua lowongan jika tidak ada pencarian
            $jobs = $this->jobModel->getAllJobs();
        }

        // Kirim variabel $jobs ke View
        require_once ROOT_PATH . 'app/views/jobs/index.php';
    }
}
?>