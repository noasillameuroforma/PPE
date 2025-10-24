<?php
declare(strict_types=1);
session_start();

// Autoload très simple
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../app/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($path)) require $path;
});

use Core\Router;

$router = new Router();

// Routes
$router->get ('/',           [Controllers\AuthController::class, 'login']);
$router->get ('/index.php',  [Controllers\AuthController::class, 'login']); // fallback si /index.php est appelé
$router->post('/login',      [Controllers\AuthController::class, 'doLogin']);
$router->get ('/dashboard',  [Controllers\AuthController::class, 'dashboard']);
$router->get ('/logout',     [Controllers\AuthController::class, 'logout']);

// Normalisation du path (gère le projet dans un sous-dossier, ex. /monapp/public)
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$scriptDir   = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/'); // ex: /monapp/public

if ($scriptDir !== '' && $scriptDir !== '/' && strncmp($requestPath, $scriptDir, strlen($scriptDir)) === 0) {
    $requestPath = substr($requestPath, strlen($scriptDir)) ?: '/';
}

if ($requestPath === '/index.php') $requestPath = '/';

$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $requestPath);
