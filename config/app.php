<?php

$router->add('/', 'App\Controllers\HomeController@index');
$router->add('/about', 'App\Controllers\HomeController@about');

// Открытые маршруты
$router->add('/login', 'App\Controllers\AuthController@showLoginPage');
$router->add('/login', 'App\Controllers\AuthController@login', ['method' => 'POST']);

// Защищённые маршруты с middleware
$router->add('/admin', 'App\Controllers\AdminController@showDashboard', ['method' => 'GET', 'middleware' => 'auth']);
$router->add('/logout', 'App\Controllers\AuthController@logout', ['method' => 'GET', 'middleware' => 'auth']);