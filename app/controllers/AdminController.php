<?php

namespace App\Controllers;

use App\Models\Discount;
use App\Models\User;
use App\Models\Item;
use App\Models\SmallOption;
use App\Validators\ProductValidator;
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

        $this->render('admin/home');
    }

    public function productForm(){
        $data['discount'] = Discount::all();
        $data['smallOption'] = SmallOption::all();
        $this->render('admin/product-form', $data);
    }

    public function addProduct(){
        $reply = [];
        $data = [
            'product_name' => $_POST['product_name'] ?? '',
            'price' => $_POST['price'] ?? '',
            'discount' => $_POST['discount'] ?? '',
            'small_option' => $_POST['small_option'] ?? [],
        ];

        $validator = new ProductValidator();

        if ($validator->validate($data)) {
            // Если валидация прошла
            $productId = Item::create(
                $data['product_name'],
                $data['price'],
                $data['discount'],
                $data['small_option']
            );
            $reply['succes'] = "Продукт успешно создан с ID: $productId";
        } else {
            // Если есть ошибки валидации
            $reply['error'] = $validator->errors();
        }
        $this->render('admin/home', $reply);
    }
}
