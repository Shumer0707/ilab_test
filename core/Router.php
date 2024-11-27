<?php

namespace Core;

class Router {
    private $routes = [];

    public function add($uri, $controller, $options = []) {
        $method = $options['method'] ?? 'GET'; // Если метод не указан, используем GET
        $middleware = $options['middleware'] ?? null; // Если middleware не указан, оставляем null
    
        $this->routes[] = [
            'uri' => trim($uri, '/'),
            'controller' => $controller,
            'method' => strtoupper($method), // Преобразуем метод в верхний регистр
            'middleware' => $middleware,
        ];
    }

    public function dispatch($uri) {
        if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|webp)$/', $uri)) {
            return false; // Оставляем обработку серверу
        }

        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        $uri = str_replace($basePath, '', $uri);

        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = trim($uri, '/'); // Удаляем лишние слэши

        // echo "Обработанный URI: " . $uri;
        $requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $requestMethod) {
                if (!empty($route['middleware'])) {
                    $this->handleMiddleware($route['middleware']);
                }
    
                $this->callController($route['controller']);
                return;
            }
        }
    
        http_response_code(404);
        echo "404 - Page not found";
    }
    
    private function handleMiddleware($middleware) {
        $middlewareClass = "Core\\Middleware\\" . ucfirst($middleware) . "Middleware";
    
        if (class_exists($middlewareClass)) {
            $middlewareClass::handle();
        } else {
            throw new \Exception("Middleware {$middleware} not found");
        }
    }

    private function callController($controller) {
        global $config; // Получаем глобальную конфигурацию

        [$controllerClass, $method] = explode('@', $controller);

        if (class_exists($controllerClass)) {
            $controllerInstance = new $controllerClass($config);
            if (method_exists($controllerInstance, $method)) {
                $controllerInstance->$method();
            } else {
                throw new \Exception("Method {$method} not found in controller {$controllerClass}");
            }
        } else {
            throw new \Exception("Class file not found for: {$controllerClass}");
        }
    }
}