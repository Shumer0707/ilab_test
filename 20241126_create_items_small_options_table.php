<?php

function migrate(PDO $db)
{
    // Создание промежуточной таблицы items_small_options
    $db->exec("
        CREATE TABLE IF NOT EXISTS items_small_options (
            item_id INT NOT NULL,
            small_option_id INT NOT NULL,
            PRIMARY KEY (item_id, small_option_id),
            CONSTRAINT fk_item FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE,
            CONSTRAINT fk_small_option FOREIGN KEY (small_option_id) REFERENCES small_options(id) ON DELETE CASCADE
        );
    ");

    echo "Таблица 'items_small_options' успешно создана.\n";
}