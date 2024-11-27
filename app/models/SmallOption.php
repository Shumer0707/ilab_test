<?php
namespace App\Models;

use Core\Model;
use PDO;
class SmallOption extends Model
{
    public static function all()
    {
        $stmt = self::query("SELECT * FROM small_options");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $stmt = self::query("SELECT * FROM small_options WHERE id = :id", ['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function items($id)
    {
        $stmt = self::query("
            SELECT i.*
            FROM items i
            INNER JOIN items_small_options iso ON i.id = iso.item_id
            WHERE iso.small_option_id = :id
        ", ['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getSumByIds(array $ids): float
    {
        if (empty($ids)) {
            return 0; // Если массив пустой, возвращаем 0
        }

        // Подготовка плейсхолдеров для запроса
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        // Выполнение запроса
        $stmt = self::query("
            SELECT SUM(price) as total
            FROM small_options
            WHERE id IN ($placeholders)
        ", $ids);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result['total'] ?? 0; // Возвращаем сумму, либо 0, если ничего не найдено
    }
}