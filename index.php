<?php
// 1. Penetapan Root Directory & Base URL
define('ROOT_PATH', __DIR__ . '/');
define('BASE_URL', 'http://localhost/Bursa-Kerja-Khusus-Dosqla');

session_start();

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
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// 2. Menentukan Controller
$controllerName = ucfirst($url[0]) . 'Controller';

// Cek apakah file controller ada
if (!file_exists(ROOT_PATH . 'app/controllers/' . $controllerName . '.php')) {
    // Jika tidak ada, tampilkan halaman 404 dan hentikan script
    http_response_code(404);
    require_once ROOT_PATH . 'app/views/404.php';
    exit;
}

$controller = new $controllerName();

// 3. Menentukan Method
$method = isset($url[1]) && method_exists($controller, $url[1]) ? $url[1] : 'index';
$params = array_slice($url, 2);

// 4. Jalankan Controller & Method
call_user_func_array([$controller, $method], $params);