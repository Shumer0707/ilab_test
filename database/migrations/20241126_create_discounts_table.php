<?php

function migrate_20241126_create_discounts_table(PDO $db)
{
    // Создание таблицы discounts
    $db->exec("
        CREATE TABLE IF NOT EXISTS discounts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            from50 INT NOT NULL,
            from100 INT NOT NULL,
            from300 INT NOT NULL,
            from500 INT NOT NULL,
            from1000 INT NOT NULL
        );
    ");

    // Добавление записей
    $stmt = $db->prepare("
        INSERT INTO discounts (title, from50, from100, from300, from500, from1000)
        VALUES
        (:title1, :from50_1, :from100_1, :from300_1, :from500_1, :from1000_1),
        (:title2, :from50_2, :from100_2, :from300_2, :from500_2, :from1000_2)
    ");

    $stmt->execute([
        ':title1' => 'small',
        ':from50_1' => 10,
        ':from100_1' => 15,
        ':from300_1' => 20,
        ':from500_1' => 25,
        ':from1000_1' => 30,
        ':title2' => 'large',
        ':from50_2' => 10,
        ':from100_2' => 20,
        ':from300_2' => 30,
        ':from500_2' => 40,
        ':from1000_2' => 50
    ]);

    echo "Миграция discounts выполнена успешно.\n";
}