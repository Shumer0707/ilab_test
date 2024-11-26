<?php

function migrate_20241126_create_items_table(PDO $db)
{
    // Удаляем таблицу items_small_options, если она существует
    $db->exec("DROP TABLE IF EXISTS items_small_options");

    // Удаляем таблицу items, если она существует
    $db->exec("DROP TABLE IF EXISTS items");

    // Удаляем таблицу small_options, если она существует
    $db->exec("DROP TABLE IF EXISTS small_options");

    // Создание таблицы small_options
    $db->exec("
        CREATE TABLE small_options (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            price DECIMAL(10, 2) NOT NULL
        );
    ");

    echo "Таблица 'small_options' успешно создана.\n";

    // Добавление записей в таблицу small_options
    $stmt = $db->prepare("
        INSERT INTO small_options (title, price)
        VALUES
        ('Option 1', 5.00),
        ('Option 2', 10.00),
        ('Option 3', 15.00),
        ('Option 4', 20.00),
        ('Option 5', 25.00)
    ");
    $stmt->execute();

    echo "Записи в таблице 'small_options' успешно добавлены.\n";

    // Создание таблицы items
    $db->exec("
        CREATE TABLE items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            discounts_id INT,
            CONSTRAINT fk_discount FOREIGN KEY (discounts_id) REFERENCES discounts(id) ON DELETE SET NULL
        );
    ");

    echo "Таблица 'items' успешно создана.\n";

    // Добавление записей в таблицу items
    $stmt = $db->prepare("
        INSERT INTO items (title, price, discounts_id)
        VALUES
        ('Item 1', 100.00, 1),
        ('Item 2', 200.00, 2)
    ");
    $stmt->execute();

    echo "Записи в таблице 'items' успешно добавлены.\n";

    // Создание промежуточной таблицы items_small_options
    $db->exec("
        CREATE TABLE items_small_options (
            item_id INT NOT NULL,
            small_option_id INT NOT NULL,
            PRIMARY KEY (item_id, small_option_id),
            CONSTRAINT fk_item FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE,
            CONSTRAINT fk_small_option FOREIGN KEY (small_option_id) REFERENCES small_options(id) ON DELETE CASCADE
        );
    ");

    echo "Таблица 'items_small_options' успешно создана.\n";

    // Пример добавления связей между items и small_options
    $stmt = $db->prepare("
        INSERT INTO items_small_options (item_id, small_option_id)
        VALUES
        (1, 1),
        (1, 2),
        (2, 3)
    ");
    $stmt->execute();

    echo "Связи между 'items' и 'small_options' успешно добавлены.\n";
}