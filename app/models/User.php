<?php

namespace App\Models;

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
                return true;
            }
        }
        return false;
    }
}