<?php

namespace App\Controllers;

use App\Models\User;
use Core\BaseController;

class AdminController extends BaseController{
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function showDashboard() {
        if (!$this->userModel->isAuthenticated()) {
            header('Location: login');
            exit();
        }

        $currentUser = $this->userModel->getCurrentUser();

        echo '<h1>Admin Dashboard</h1>';
        echo '<p>Welcome, ' . htmlspecialchars($currentUser['username']) . '!</p>';
        echo '<a href="/logout">Logout</a>';
    }
}
// class AdminController {
//     public function showDashboard() {
//         if (!Session::get('is_authenticated')) {
//             header('Location: /login');
//             exit();
//         }
//         include __DIR__ . '/../views/admin.php';
//     }
// }