<?php

namespace Core;

use PDO;

abstract class Model
{
    protected static function getDB()
    {
        static $db = null;
        if ($db === null) {
            $config = require __DIR__ . '/../config/database.php';
            $db = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8",
                $config['username'],
                $config['password']
            );
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }
}