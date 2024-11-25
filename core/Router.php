<?php

namespace Core;

class Router
{
    private $routes = [];

    public function add($route, $handler)
    {
        // echo "Adding route: $route -> $handler <br>";
        $this->routes[$route] = $handler;
    }

    public function dispatch($uri)
    {
        // echo "Original URI: $uri <br>";

        $uri = str_replace('/ilab/mscard', '', $uri);
        $uri = trim($uri, '/');

        if ($uri === '') {
            $uri = '/';
        }

        // echo "Processed URI: $uri <br>";

        if (array_key_exists($uri, $this->routes)) {
            [$controller, $action] = explode('@', $this->routes[$uri]);
            $controllerClass = "\\App\\Controllers\\$controller";

            // echo "Dispatching to controller: $controllerClass, action: $action <br>";

            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                if (method_exists($controllerInstance, $action)) {
                    $controllerInstance->$action();
                    return;
                } else {
                    echo "Method $action not found in controller $controllerClass";
                }
            } else {
                echo "Controller $controllerClass not found";
            }
        } else {
            echo "Route not found for URI: $uri";
        }
    }
}