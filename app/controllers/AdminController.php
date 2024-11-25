<?php

namespace App\Controllers;

use Core\Session;

class AdminController {
    public function showDashboard() {
        if (!Session::get('is_authenticated')) {
            header('Location: /login');
            exit();
        }
        include __DIR__ . '/../Views/admin.php';
    }
}