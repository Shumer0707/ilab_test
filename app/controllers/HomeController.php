<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\User;

class HomeController extends BaseController
{
    public function index()
    {
        // $users = User::getAll();
        // print_r($users);
        // exit;
        // $this->render('test');
        // $this->render('test', ['users' => $users]);
        $this->render('index');
    }

    public function about()
    {

    }
}