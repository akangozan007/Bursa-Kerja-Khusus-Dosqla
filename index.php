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

// 2. Parse & Routing URL
$rawUrl = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$rawUrl = filter_var($rawUrl, FILTER_SANITIZE_URL);
$url = explode('/', $rawUrl);

$controllerSegment = strtolower($url[0] ?? 'home');
$actionSegment     = strtolower($url[1] ?? 'index');

// Mapping Routing Pemisahan Auth, Register, Pelamar, dan Controller Lainnya
if ($controllerSegment === 'login') {
    // Alias route: /login -> AuthController -> index()
    $controllerName = 'AuthController';
    $method = 'index';
} elseif ($controllerSegment === 'register') {
    // Alias route: /register -> DaftarController -> index()
    $controllerName = 'DaftarController';
    $method = 'index';
}elseif ($controllerSegment === 'pelamar') {
    // Route /pelamar akan memanggil PelamarController
    $controllerName = 'PelamarController';
    $method = ($actionSegment === 'index') ? 'index' : $actionSegment;
}
elseif ($controllerSegment === 'auth') {
    if ($actionSegment === 'adminxxx') {
        // Alias route: /auth/adminxxx -> DaftarController -> adminxxx()
        $controllerName = 'DaftarController';
        $method = 'adminxxx';
    } else {
        $controllerName = 'AuthController';
        // /auth atau /auth/login -> AuthController -> index()
        $method = ($actionSegment === 'login' || $actionSegment === 'index') ? 'index' : $actionSegment;
    }
} elseif ($controllerSegment === 'daftar') {
    $controllerName = 'DaftarController';
    $method = $actionSegment;
} elseif ($controllerSegment === 'logout') {
    $controllerName = 'LogoutController';
    $method = 'index';
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

// 4. Menentukan & Cek Method
if (!method_exists($controller, $method)) {
    die("Method <strong>{$method}</strong> tidak ditemukan pada controller <strong>{$controllerName}</strong>.");
}

$params = array_slice($url, 2);

// 5. Eksekusi Controller & Method
call_user_func_array([$controller, $method], $params);