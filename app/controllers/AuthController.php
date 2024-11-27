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

        if (isset($_SESSION['user'])) {
            header('Location: admin');
            exit;
        }
        include __DIR__ . '/../views/login.php';
    }

    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        if ($this->userModel->authenticate($username, $password)) {
            header("Location: admin");
        } else {
            echo 'Invalid credentials.';
            $this->showLoginPage();
        }
    }

    public function logout() {
        $this->userModel->logout();
        header('Location: login');
    }
}