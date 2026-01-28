<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function showLogin()
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        
        $this->view('auth.login');
    }

    public function login()
    {
        $this->validateCsrf();
        
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Please provide both username and password.';
            $this->redirect('/login');
        }
        
        try {
            $user = $this->userModel->authenticate($username, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['success'] = 'Welcome back, ' . $user['full_name'] . '!';
                
                $this->redirect('/dashboard');
            } else {
                $_SESSION['error'] = 'Invalid username or password.';
                $this->redirect('/login');
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Login failed. Please try again later.';
            $this->redirect('/login');
        }
    }

    public function showRegister()
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        
        $this->view('auth.register');
    }

    public function register()
    {
        $this->validateCsrf();
        
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $fullName = trim($_POST['full_name'] ?? '');
        
        // Validation
        $errors = [];
        
        if (empty($username) || strlen($username) < 3) {
            $errors[] = 'Username must be at least 3 characters.';
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid email address.';
        }
        
        if (empty($password) || strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }
        
        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match.';
        }
        
        if (empty($fullName)) {
            $errors[] = 'Full name is required.';
        }
        
        // Check if username exists
        try {
            if ($this->userModel->findByUsername($username)) {
                $errors[] = 'Username already exists.';
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Registration failed. Please try again later.';
            $this->redirect('/register');
        }
        
        // Check if email exists
        try {
            if ($this->userModel->findByEmail($email)) {
                $errors[] = 'Email already exists.';
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Registration failed. Please try again later.';
            $this->redirect('/register');
        }
        
        if (!empty($errors)) {
            $_SESSION['error'] = implode(' ', $errors);
            $_SESSION['old'] = $_POST;
            $this->redirect('/register');
        }
        
        // Create user
        try {
            $userId = $this->userModel->createUser([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'full_name' => $fullName,
                'role' => 'reader'
            ]);
            
            if ($userId) {
                $_SESSION['success'] = 'Registration successful! Please log in.';
                $this->redirect('/login');
            } else {
                $_SESSION['error'] = 'Registration failed. Please try again.';
                $this->redirect('/register');
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Registration failed. Please try again later.';
            $this->redirect('/register');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }

    public function dashboard()
    {
        $this->requireAuth();
        
        if ($this->isLibrarian()) {
            $this->view('dashboard.librarian');
        } else {
            $this->view('dashboard.reader');
        }
    }
}
