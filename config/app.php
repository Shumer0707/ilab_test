<?php

$router->add('/', 'App\Controllers\HomeController@index');
$router->add('/show/{search}', 'App\Controllers\HomeController@showProduct', ['method' => 'GET']);

// Открытые маршруты
$router->add('/login', 'App\Controllers\AuthController@showLoginPage');
$router->add('/login', 'App\Controllers\AuthController@login', ['method' => 'POST']);

// Защищённые маршруты с middleware
$router->add('/admin', 'App\Controllers\AdminController@showDashboard', ['method' => 'GET', 'middleware' => 'auth']);
$router->add('/product-form', 'App\Controllers\AdminController@productForm', ['method' => 'GET', 'middleware' => 'auth']);
$router->add('/add-product', 'App\Controllers\AdminController@addProduct', ['method' => 'POST', 'middleware' => 'auth']);

$router->add('/logout', 'App\Controllers\AuthController@logout', ['method' => 'GET', 'middleware' => 'auth']);