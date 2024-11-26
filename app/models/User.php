<?php

namespace App\Models;

use Core\Session;
use Core\Model;
use PDO;

// class User extends Model
// {
//     public static function getAll()
//     {
//         $db = self::getDB();
//         $stmt = $db->query('SELECT * FROM users');
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }
// }


class User {
    private $users = [
        ['username' => 'admin', 'password' => '12345'], // Пример данных
    ];

    public function authenticate($username, $password) {
        foreach ($this->users as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                // Успешная аутентификация, сохраняем пользователя в сессию
                Session::set('user', $user);
                return true;
            }
        }
        return false;
    }

    public function isAuthenticated() {
        return Session::get('user') !== null;
    }

    public function logout() {
        Session::destroy();
    }

    public function getCurrentUser() {
        return Session::get('user');
    }
}