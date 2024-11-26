<?php

namespace Core;

use PDO;

abstract class Model
{
    public static function getDB()
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

    // Метод для выполнения запросов
    protected static function query($sql, $params = [])
    {
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}