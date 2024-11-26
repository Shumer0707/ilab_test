<?php

namespace App\Controllers;

use App\Models\User;
use Core\BaseController;

class AuthController extends BaseController{
    private $userModel;
    protected $config;

    public function __construct($config) {
        $this->config = $config;
        $this->userModel = new User();
    }
    
    public function showLoginPage() {
        // $viewPath = $this->config['viewPath'];
        include __DIR__ . '/../views/login.php';
    }

    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        // $basePath = $this->config['basePath'];
        // echo '<pre>';
        // print_r($basePath);
        // echo '</pre>';
        // exit;
        if ($this->userModel->authenticate($username, $password)) {
            header("Location: /admin");
        } else {
            echo 'Invalid credentials.';
            $this->showLoginPage();
        }
    }

    public function logout() {
        $this->userModel->logout();
        header('Location: /login');
    }
}