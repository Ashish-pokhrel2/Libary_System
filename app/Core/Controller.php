<?php

namespace App\Core;

use App\Core\BladeEngine;

class Controller
{
    protected $blade;

    public function __construct()
    {
        $this->blade = new BladeEngine();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function view($template, $data = [])
    {
        echo $this->blade->render($template, $data);
    }

    protected function redirect($url)
    {
        // Handle base path for shared hosting
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        $basePath = ($scriptName !== '/' && $scriptName !== '\\') ? $scriptName : '';
        
        // If URL is relative (starts with /), prepend base path
        if (strpos($url, '/') === 0 && strpos($url, $basePath) !== 0) {
            $url = $basePath . $url;
        }
        
        header("Location: {$url}");
        exit;
    }

    protected function isAuthenticated()
    {
        return isset($_SESSION['user_id']);
    }

    protected function isLibrarian()
    {
        return $this->isAuthenticated() && $_SESSION['user_role'] === 'librarian';
    }

    protected function isReader()
    {
        return $this->isAuthenticated() && $_SESSION['user_role'] === 'reader';
    }

    protected function requireAuth()
    {
        if (!$this->isAuthenticated()) {
            $_SESSION['error'] = 'You must be logged in to access this page.';
            $this->redirect('/login');
        }
    }

    protected function requireLibrarian()
    {
        $this->requireAuth();
        
        if (!$this->isLibrarian()) {
            $_SESSION['error'] = 'You do not have permission to access this page.';
            $this->redirect('/dashboard');
        }
    }

    protected function validateCsrf()
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed.');
        }
    }
}
