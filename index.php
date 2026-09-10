<?php
// 1. Penetapan Root Directory & Base URL
define('ROOT_PATH', __DIR__ . '/');
define('BASE_URL', 'http://localhost/Bursa-Kerja-Khusus-Dosqla/');

session_start();

// Enable Error Reporting untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload Sederhana (Dengan penanganan lowercase untuk file controller & model)
spl_autoload_register(function ($class_name) {
    $class_file = strtolower($class_name) . '.php';

    if (file_exists(ROOT_PATH . 'app/controllers/' . $class_file)) {
        require_once ROOT_PATH . 'app/controllers/' . $class_file;
    } elseif (file_exists(ROOT_PATH . 'app/models/' . $class_file)) {
        require_once ROOT_PATH . 'app/models/' . $class_file;
    } elseif (file_exists(ROOT_PATH . 'app/models/' . $class_name . '.php')) {
        require_once ROOT_PATH . 'app/models/' . $class_name . '.php';
    } elseif (file_exists(ROOT_PATH . 'config/' . $class_file)) {
        require_once ROOT_PATH . 'config/' . $class_file;
    }
});

// 2. Parse & Routing URL (Pembersihan URL kompatibel PHP 8.2+)
$rawUrl = isset($_GET['url']) ? trim($_GET['url'], '/') : 'home';
$rawUrl = filter_var($rawUrl, FILTER_DEFAULT);
$url = !empty($rawUrl) ? explode('/', $rawUrl) : ['home'];

$controllerSegment = strtolower($url[0] ?? 'home');
$actionSegment     = strtolower($url[1] ?? 'index');

// Mapping Routing Pemisahan Admin, Pelamar, & Auth
if ($controllerSegment === 'admin') {
    // Route /admin -> AdminController
    $controllerName = 'AdminController';
    
    // Normalisasi action segment (Menangani URL berkebab-case)
    if ($actionSegment === 'kelola-pelamar') {
        $method = 'kelolaPelamar';
    } elseif ($actionSegment === 'kelola-lowongan') {
        $method = 'kelolaLowongan';
    } elseif ($actionSegment === 'kelola-user') {
        $method = 'kelolaUser';
    } elseif ($actionSegment === 'update-status-pelamar' || $actionSegment === 'updatestatuspelamar') {
        $method = 'updateStatusPelamar';
    } elseif ($actionSegment === 'toggle-user-status') {
        $method = 'toggle_user_status';
    } elseif ($actionSegment === 'reset-user-password') {
        $method = 'reset_user_password';
    } else {
        $method = ($actionSegment === 'index') ? 'index' : $actionSegment;
    }

} elseif ($controllerSegment === 'pelamar' || $controllerSegment === 'applicant') {
    // Route /pelamar/profile -> PelamarController -> profile()
    $controllerName = 'PelamarController';
    $method = ($actionSegment === 'index') ? 'index' : $actionSegment;

} elseif ($controllerSegment === 'daftar' || $controllerSegment === 'register') {
    // Alias route: /daftar atau /register -> PelamarController -> daftar()
    $controllerName = 'PelamarController';
    $method = ($actionSegment === 'index') ? 'daftar' : $actionSegment;

} elseif ($controllerSegment === 'home') {
    // Route /home -> AuthController -> home()
    $controllerName = 'AuthController';
    $method = 'home';

} elseif ($controllerSegment === 'jobs' || $controllerSegment === 'job') {
    // Route /jobs atau /job -> AuthController -> jobs()
    $controllerName = 'AuthController';
    $method = ($actionSegment === 'index' || empty($actionSegment)) ? 'jobs' : $actionSegment;

} elseif ($controllerSegment === 'login') {
    // Alias route: /login -> AuthController -> index()
    $controllerName = 'AuthController';
    $method = 'index';

} elseif ($controllerSegment === 'logout') {
    // Alias route: /logout -> AuthController -> logout()
    $controllerName = 'AuthController';
    $method = 'logout';

} elseif ($controllerSegment === 'auth') {
    if ($actionSegment === 'adminxxx') {
        $controllerName = 'AdminController';
        $method = 'adminxxx';
    } else {
        $controllerName = 'AuthController';
        $method = ($actionSegment === 'login' || $actionSegment === 'index') ? 'index' : $actionSegment;
    }

} else {
    $controllerName = ucfirst($controllerSegment) . 'Controller';
    $method = $actionSegment;
}

// 3. Menentukan & Load Controller
$controllerFile = strtolower($controllerName) . '.php';

if (!file_exists(ROOT_PATH . 'app/controllers/' . $controllerFile)) {
    http_response_code(404);
    if (file_exists(ROOT_PATH . 'app/views/404.php')) {
        require_once ROOT_PATH . 'app/views/404.php';
    } else {
        echo "404 - Controller <strong>{$controllerName}</strong> tidak ditemukan.";
    }
    exit;
}

$controller = new $controllerName();

// 4. Menentukan & Cek Method (Validasi method publik dan callable)
if (!method_exists($controller, $method) || !is_callable([$controller, $method])) {
    http_response_code(404);
    if (file_exists(ROOT_PATH . 'app/views/404.php')) {
        require_once ROOT_PATH . 'app/views/404.php';
    } else {
        echo "404 - Method <strong>{$method}</strong> tidak ditemukan atau bersifat privat pada controller <strong>{$controllerName}</strong>.";
    }
    exit;
}

$params = array_slice($url, 2);

// 5. Eksekusi Controller & Method
call_user_func_array([$controller, $method], $params);