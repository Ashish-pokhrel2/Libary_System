<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/helpers.php';

// Error and exception handling
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../storage/logs/php_errors.log');

// Global exception handler
set_exception_handler(function ($exception) {
    // Log the error
    $logFile = __DIR__ . '/../storage/logs/error.log';
    $logDir = dirname($logFile);

    if (!is_dir($logDir)) {
        @mkdir($logDir, 0755, true);
    }

    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] EXCEPTION: " . $exception->getMessage() . "\n";
    $logMessage .= "File: " . $exception->getFile() . " (Line: " . $exception->getLine() . ")\n";
    $logMessage .= "Stack trace:\n" . $exception->getTraceAsString() . "\n\n";
    @file_put_contents($logFile, $logMessage, FILE_APPEND);

    // Show error page
    http_response_code(500);
    $errorMessage = 'An unexpected error occurred';

    echo "<!DOCTYPE html><html><head><title>Server Error</title></head><body>";
    echo "<h1>500 - Internal Server Error</h1>";
    echo "<p>An unexpected error occurred.</p>";
    echo "<pre>" . htmlspecialchars($exception->getMessage()) . "</pre>";
    echo "<pre>" . htmlspecialchars($exception->getTraceAsString()) . "</pre>";
    echo "</body></html>";
    exit;
});

// Global error handler
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }

    $logFile = __DIR__ . '/../storage/logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] ERROR [{$errno}]: {$errstr} in {$errfile} on line {$errline}\n";
    @file_put_contents($logFile, $logMessage, FILE_APPEND);

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);

    return true;
});

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Simple router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

try {
    // Route definitions
    $routes = [
        'GET' => [
            '/' => ['App\Controllers\AuthController', 'showLogin'],
            '/login' => ['App\Controllers\AuthController', 'showLogin'],
            '/register' => ['App\Controllers\AuthController', 'showRegister'],
            '/logout' => ['App\Controllers\AuthController', 'logout'],
            '/dashboard' => ['App\Controllers\AuthController', 'dashboard'],
            '/authors' => ['App\Controllers\AuthorController', 'index'],
            '/authors/create' => ['App\Controllers\AuthorController', 'create'],
        ],

        'POST' => [
            '/login' => ['App\Controllers\AuthController', 'login'],
            '/register' => ['App\Controllers\AuthController', 'register'],
            '/authors/store' => ['App\Controllers\AuthorController', 'store'],

        ]
    ];

    // Check for exact match
    if (isset($routes[$method][$uri])) {
        [$controllerName, $action] = $routes[$method][$uri];
        $controller = new $controllerName();
        $controller->$action();
        exit;
    }

    // Authors dynamic routes
    if (preg_match('#^/authors/edit/(\d+)$#', $uri, $matches)) {
        $controller = new \App\Controllers\AuthorController();
        $controller->edit($matches[1]);
        exit;
    }

    if (preg_match('#^/authors/update/(\d+)$#', $uri, $matches) && $method === 'POST') {
        $controller = new \App\Controllers\AuthorController();
        $controller->update($matches[1]);
        exit;
    }

    if (preg_match('#^/authors/delete/(\d+)$#', $uri, $matches)) {
        $controller = new \App\Controllers\AuthorController();
        $controller->delete($matches[1]);
        exit;
    }







    // 404 Not Found
    http_response_code(404);
    echo "404 - Page Not Found";

} catch (\Exception $e) {
    // Re-throw to be caught by global exception handler
    throw $e;
}
