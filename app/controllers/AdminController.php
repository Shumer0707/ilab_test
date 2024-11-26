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

        // $currentUser = $this->userModel->getCurrentUser();
        include __DIR__ . '/../views/admin/home.php';
    }

    public function productForm(){
        include __DIR__ . '/../views/admin/product-form.php';
    }

    public function addProduct(){
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
    }
}
