<?php

require_once __DIR__ . '/../core/Model.php';

use Core\Model;

// Получаем подключение к базе данных
$db = Model::getDB();

// Создаём таблицу миграций, если её ещё нет
ensureMigrationsTableExists($db);

// Получаем список выполненных миграций
$executedMigrations = $db->query("SELECT migration FROM migrations")->fetchAll(PDO::FETCH_COLUMN);

// Получаем список всех файлов миграций из папки
$migrationFiles = glob(__DIR__ . '/migrations/*.php');

// Выполняем миграции, которые ещё не запускались
foreach ($migrationFiles as $file) {
    $migrationName = basename($file);
    require_once $file;

    // Генерируем имя функции миграции
    $functionName = 'migrate_' . pathinfo($migrationName, PATHINFO_FILENAME);

    if (function_exists($functionName)) {
        echo "Выполняем миграцию: $migrationName\n";
        $functionName($db); // Вызываем уникальную функцию миграции
        echo "Миграция $migrationName успешно выполнена.\n";

        // Сохраняем выполненную миграцию
        $db->prepare("INSERT INTO migrations (migration) VALUES (:migration)")
           ->execute([':migration' => $migrationName]);
    } else {
        echo "Ошибка: Функция $functionName не найдена в $file.\n";
    }
}

function ensureMigrationsTableExists(PDO $db)
{
    $db->exec("
        CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");
}