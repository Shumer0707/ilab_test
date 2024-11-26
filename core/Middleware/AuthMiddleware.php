<?php

namespace Core\Middleware;

use Core\Session;

class AuthMiddleware {
    public static function handle() {
        if (!Session::get('user')) {
            header('Location: login');
            exit;
        }
    }
}