<?php

namespace App\Controllers;

use Core\Session;
use App\Models\User;

class AuthController {
    public function showLoginPage() {
        include __DIR__ . '/../views/login.php';
    }

    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();

        if ($userModel->authenticate($username, $password)) {
            Session::set('is_authenticated', true);
            header('Location: /admin');
        } else {
            echo "Invalid credentials!";
            $this->showLoginPage();
        }
    }

    public function logout() {
        Session::destroy();
        header('Location: /login');
    }
}