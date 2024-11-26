<?php

// spl_autoload_register(function ($class) {
//     $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
//     if (file_exists($path)) {
//         require_once $path;
//     } else {
//         throw new \Exception("Class file not found for: {$class}");
//     }
// });
spl_autoload_register(function ($class) {
    // Определение базовых пространств имен
    $prefixes = [
        'Core\\' => __DIR__ . '/core/',
        'App\\Models\\' => __DIR__ . '/app/models/',
        'App\\Controllers\\' => __DIR__ . '/app/controllers/',
        'App\\Validators\\' => __DIR__ . '/app/validators/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        if (strpos($class, $prefix) === 0) {
            $relativeClass = substr($class, strlen($prefix));
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }

    throw new Exception("Class file not found for: $class");
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