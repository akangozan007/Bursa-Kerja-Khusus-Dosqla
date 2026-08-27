<?php
// 1. Penetapan Root Directory & Base URL (Tambahkan trailing slash)
define('ROOT_PATH', __DIR__ . '/');
define('BASE_URL', 'http://localhost/Bursa-Kerja-Khusus-Dosqla');

session_start();

// Enable Error Reporting untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload Sederhana
spl_autoload_register(function ($class_name) {
    if (file_exists(ROOT_PATH . 'app/controllers/' . $class_name . '.php')) {
        require_once ROOT_PATH . 'app/controllers/' . $class_name . '.php';
    } elseif (file_exists(ROOT_PATH . 'app/models/' . $class_name . '.php')) {
        require_once ROOT_PATH . 'app/models/' . $class_name . '.php';
    } elseif (file_exists(ROOT_PATH . 'config/' . $class_name . '.php')) {
        require_once ROOT_PATH . 'config/' . $class_name . '.php';
    }
});

// Parse URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'daftar';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Mapping alias URL (opsional: agar URL /auth/process_register otomatis panggil DaftarController)
if (strtolower($url[0]) === 'auth') {
    $url[0] = 'daftar';
}

// 2. Menentukan Controller
$controllerName = ucfirst($url[0]) . 'Controller';

// Cek apakah file controller ada
if (!file_exists(ROOT_PATH . 'app/controllers/' . $controllerName . '.php')) {
    http_response_code(404);
    if (file_exists(ROOT_PATH . 'app/views/404.php')) {
        require_once ROOT_PATH . 'app/views/404.php';
    } else {
        echo "404 - Controller <strong>{$controllerName}</strong> tidak ditemukan.";
    }
    exit;
}

$controller = new $controllerName();

// 3. Menentukan Method
$method = isset($url[1]) ? $url[1] : 'index';

if (!method_exists($controller, $method)) {
    die("Method <strong>{$method}</strong> tidak ditemukan pada controller <strong>{$controllerName}</strong>.");
}

$params = array_slice($url, 2);

// 4. Jalankan Controller & Method
call_user_func_array([$controller, $method], $params);