<?php

namespace App\Controllers;

use Core\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $this->render('index');
    }

    public function showProduct()
    {
        $search = $_GET['search'] ?? null;

        if ($search) {
            echo "Результат поиска: " . htmlspecialchars($search);
        } else {
            echo "Введите запрос для поиска.";
        }
        // print_r($_POST);
    }
}