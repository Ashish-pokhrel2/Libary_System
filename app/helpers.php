<?php

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = $_ENV[$key] ?? getenv($key);
        
        if ($value === false) {
            return $default;
        }
        
        // Convert string booleans to actual booleans
        if (is_string($value)) {
            $lower = strtolower($value);
            if ($lower === 'true' || $lower === '(true)') {
                return true;
            }
            if ($lower === 'false' || $lower === '(false)') {
                return false;
            }
            if ($lower === 'null' || $lower === '(null)') {
                return null;
            }
        }
        
        return $value;
    }
}

if (!function_exists('config')) {
    function config($key, $default = null)
    {
        static $config = [];
        
        if (empty($config)) {
            $config = [
                'app' => [
                    'debug' => env('APP_DEBUG', true),
                    'name' => env('APP_NAME', 'Library System'),
                    'url' => env('APP_URL', 'http://localhost:8000'),
                ],
                'database' => require __DIR__ . '/../config/database.php',
            ];
        }
        
        $keys = explode('.', $key);
        $value = $config;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }
        
        return $value;
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field()
    {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token'] ?? '') . '">';
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token()
    {
        return $_SESSION['csrf_token'] ?? '';
    }
}

if (!function_exists('old')) {
    function old($key, $default = '')
    {
        return $_SESSION['old'][$key] ?? $default;
    }
}

if (!function_exists('asset')) {
    function asset($path)
    {
        return '/' . ltrim($path, '/');
    }
}

if (!function_exists('url')) {
    function url($path = '')
    {
        return rtrim('http://localhost:8080', '/') . '/' . ltrim($path, '/');
    }
}
