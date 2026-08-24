<?php
session_start();

// Autoload Sederhana
spl_autoload_register(function ($class_name) {
    if (file_exists('app/controllers/' . $class_name . '.php')) {
        require_once 'app/controllers/' . $class_name . '.php';
    } elseif (file_exists('app/models/' . $class_name . '.php')) {
        require_once 'app/models/' . $class_name . '.php';
    } elseif (file_exists('config/' . $class_name . '.php')) {
        require_once 'config/' . $class_name . '.php';
    }
});

// Parse URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Menentukan Controller
$controllerName = ucfirst($url[0]) . 'Controller';
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    $controllerName = 'HomeController';
}

$controller = new $controllerName();

// Menentukan Method
$method = isset($url[1]) && method_exists($controller, $url[1]) ? $url[1] : 'index';
$params = array_slice($url, 2);

// Jalankan Controller & Method
call_user_func_array([$controller, $method], $params);