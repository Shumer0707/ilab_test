<?php

namespace Core\Middleware;

use Core\Session;

class AuthMiddleware {
    public static function handle() {
        if (!Session::get('is_authenticated')) {
            header('Location: /login');
            exit();
        }
    }
}