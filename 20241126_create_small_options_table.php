<?php

function migrate_20241126_create_small_options_table(PDO $db)
{
    // Создание таблицы small_options
    $db->exec("
        CREATE TABLE IF NOT EXISTS small_options (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            price DECIMAL(10, 2) NOT NULL
        );
    ");

    echo "Таблица 'small_options' успешно создана.\n";

    // Добавление записей
    $stmt = $db->prepare("
        INSERT INTO small_options (title, price)
        VALUES 
        (:title1, :price1),
        (:title2, :price2),
        (:title3, :price3),
        (:title4, :price4),
        (:title5, :price5)
    ");

    $stmt->execute([
        ':title1' => 'Option 1',
        ':price1' => 5.00,
        ':title2' => 'Option 2',
        ':price2' => 10.00,
        ':title3' => 'Option 3',
        ':price3' => 15.00,
        ':title4' => 'Option 4',
        ':price4' => 20.00,
        ':title5' => 'Option 5',
        ':price5' => 25.00
    ]);

    echo "Записи в таблице 'small_options' успешно добавлены.\n";
}