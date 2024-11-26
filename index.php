<?php

// Автозагрузка классов
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

    // Отладка: покажите класс и путь
    // var_dump(['class' => $class, 'path' => $path]);

    if (file_exists($path)) {
        require_once $path;
    } else {
        throw new \Exception("Class file not found for: {$class}");
    }
});

use Core\Session;
use Core\Router;

// Запускаем сессию
Session::start();

// Создаём маршрутизатор
$router = new Router();

// Подключаем маршруты
require_once __DIR__ . '/config/app.php';
$config = require __DIR__ . '/config/path.php';
// Выполняем маршрутизацию
$router->dispatch($_SERVER['REQUEST_URI']);