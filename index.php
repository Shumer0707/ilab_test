<?php

// Автозагрузка классов
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

use Core\Router;
use Core\Session;
use App\Controllers\AuthController;
use App\Controllers\AdminController;

Session::start();

// Создаём экземпляр маршрутизатора
$router = new Router();

$authController = new AuthController();
$adminController = new AdminController();

// Подключаем маршруты
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/core/Session.php';
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/AdminController.php';

// Выполняем маршрутизацию
$router->dispatch($_SERVER['REQUEST_URI']);