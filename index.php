<?php

define('ALLOW_ACCESS', true);

require __DIR__ . "/configs/app.php";

$request = $_SERVER['REQUEST_URI'];
$request = parse_url($request, PHP_URL_PATH);
$request = trim($request, '/');

$path = explode('/', $request);

$main_route = $path[0];


// Add main routes
$routes = [
    '' => 'home.php',
];


// routes mapping
if (array_key_exists($request, $routes)) {
    $view_path = __DIR__ . "/views/" . $routes[$request];
} else {
    $view_path = __DIR__ . "/views/" . $main_route . ".php";
}

if (file_exists($view_path)) {
    require $view_path;
} else {
    header("HTTP/1.0 404 Not Found");
    require __DIR__ . '/views/404.php';
}
