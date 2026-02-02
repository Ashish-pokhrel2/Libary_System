<?php

// Root index.php - for shared hosting deployment
// This file should be placed in public_html/ on the server
// All files from public/ folder (css, js) should also be in public_html/

require_once __DIR__ . '/../LibarySystem/vendor/autoload.php';
require_once __DIR__ . '/../LibarySystem/app/helpers.php';

// Error and exception handling
error_reporting(E_ALL);
ini_set('display_errors', '1'); // Show errors for debugging
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../LibarySystem/storage/logs/php_errors.log');

// Global exception handler
set_exception_handler(function ($exception) {
    // Log the error
    $logFile = __DIR__ . '/../LibarySystem/storage/logs/error.log';
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
    
    // Try to load BladeEngine for pretty error page
    try {
        $blade = new \App\Core\BladeEngine();
        
        echo $blade->render('errors.500', []);
    } catch (\Exception $e) {
        // Fallback to basic HTML if BladeEngine fails
        echo "<!DOCTYPE html><html><head><title>Server Error</title></head><body>";
        echo "<h1>500 - Internal Server Error</h1>";
        echo "<p>An unexpected error occurred. Please try again later.</p>";
        if (ini_get('display_errors')) {
            echo "<pre>" . htmlspecialchars($exception->getMessage()) . "</pre>";
        }
        echo "</body></html>";
    }
    exit;
});

// Global error handler
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }

    $logFile = __DIR__ . '/storage/logs/error.log';
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

// Simple router - Fixed for shared hosting
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Handle shared hosting base path (e.g., /~np02cs4a240019)
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$basePath = '';
if ($scriptName !== '/' && $scriptName !== '\\') {
    $basePath = rtrim($scriptName, '/');
    // Remove the base path from URI
    if (strpos($uri, $basePath) === 0) {
        $uri = substr($uri, strlen($basePath));
    }
}

// Ensure URI starts with /
$uri = '/' . ltrim($uri, '/');

// Handle static files - don't route CSS/JS/images through PHP
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/i', $uri)) {
    http_response_code(404);
    exit('Static file not found');
}

// Set base URL for forms and links
define('BASE_URL', $basePath);

// Handle empty URI (root)
if ($uri === '/' || $uri === '') {
    $uri = '/';
}

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
            '/categories' => ['App\Controllers\CategoryController', 'index'],
            '/categories/create' => ['App\Controllers\CategoryController', 'create'],
            '/books' => ['App\Controllers\BookController', 'index'],
            '/books/create' => ['App\Controllers\BookController', 'create'],
            '/books/search' => ['App\Controllers\BookController', 'search'],
            '/books/autocomplete' => ['App\Controllers\BookController', 'autocomplete'],
        ],
        'POST' => [
            '/login' => ['App\Controllers\AuthController', 'login'],
            '/register' => ['App\Controllers\AuthController', 'register'],
            '/authors' => ['App\Controllers\AuthorController', 'store'],
            '/authors/store' => ['App\Controllers\AuthorController', 'store'],
            '/categories' => ['App\Controllers\CategoryController', 'store'],
            '/categories/store' => ['App\Controllers\CategoryController', 'store'],
            '/books' => ['App\Controllers\BookController', 'store'],
            '/books/store' => ['App\Controllers\BookController', 'store'],
            '/books/search' => ['App\Controllers\BookController', 'search'],
        ],
        'PUT' => [
            // PUT routes will be handled via POST with _method override
        ],
        'DELETE' => [
            // DELETE routes will be handled via POST with _method override
        ],
    ];

    // Handle method override for PUT and DELETE
    if ($method === 'POST' && isset($_POST['_method'])) {
        $method = strtoupper($_POST['_method']);
    }

    // Check if route exists
    if (isset($routes[$method][$uri])) {
        [$controller, $action] = $routes[$method][$uri];
        $controllerInstance = new $controller();
        $controllerInstance->$action();
    } else {
        // Try dynamic routes with parameters
        $matched = false;

        // Authors routes with ID - support /authors/edit/{id} format
        if (preg_match('#^/authors/edit/(\d+)$#', $uri, $matches)) {
            $controller = new \App\Controllers\AuthorController();
            $controller->edit($matches[1]);
            $matched = true;
        } elseif ($method === 'POST' && preg_match('#^/authors/update/(\d+)$#', $uri, $matches)) {
            $controller = new \App\Controllers\AuthorController();
            $controller->update($matches[1]);
            $matched = true;
        } elseif (preg_match('#^/authors/delete/(\d+)$#', $uri, $matches)) {
            $controller = new \App\Controllers\AuthorController();
            $controller->delete($matches[1]);
            $matched = true;
        }
        // Categories routes with ID - support /categories/edit/{id} format
        elseif (preg_match('#^/categories/edit/(\d+)$#', $uri, $matches)) {
            $controller = new \App\Controllers\CategoryController();
            $controller->edit($matches[1]);
            $matched = true;
        } elseif ($method === 'POST' && preg_match('#^/categories/update/(\d+)$#', $uri, $matches)) {
            $controller = new \App\Controllers\CategoryController();
            $controller->update($matches[1]);
            $matched = true;
        } elseif (preg_match('#^/categories/delete/(\d+)$#', $uri, $matches)) {
            $controller = new \App\Controllers\CategoryController();
            $controller->delete($matches[1]);
            $matched = true;
        }
        // Books routes with ID - support /books/show/{id}, /books/edit/{id} format
        elseif (preg_match('#^/books/show/(\d+)$#', $uri, $matches)) {
            $controller = new \App\Controllers\BookController();
            $controller->show($matches[1]);
            $matched = true;
        } elseif (preg_match('#^/books/edit/(\d+)$#', $uri, $matches)) {
            $controller = new \App\Controllers\BookController();
            $controller->edit($matches[1]);
            $matched = true;
        } elseif ($method === 'POST' && preg_match('#^/books/update/(\d+)$#', $uri, $matches)) {
            $controller = new \App\Controllers\BookController();
            $controller->update($matches[1]);
            $matched = true;
        } elseif (preg_match('#^/books/delete/(\d+)$#', $uri, $matches)) {
            $controller = new \App\Controllers\BookController();
            $controller->delete($matches[1]);
            $matched = true;
        }

        if (!$matched) {
            // 404 - Not Found
            http_response_code(404);
            try {
                $blade = new \App\Core\BladeEngine();
                echo $blade->render('errors.404', []);
            } catch (\Exception $e) {
                echo "<!DOCTYPE html><html><head><title>Not Found</title></head><body>";
                echo "<h1>404 - Page Not Found</h1>";
                echo "</body></html>";
            }
        }
    }
} catch (\Exception $e) {
    throw $e; // Let the global exception handler deal with it
}