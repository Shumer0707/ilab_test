<?php
namespace App\Models;
use PDO;
use Core\Model;
use Exception;
class Item extends Model
{
    public static function all()
    {
        $stmt = self::query("SELECT * FROM items");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $stmt = self::query("SELECT * FROM items WHERE id = :id", ['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function discount($id)
    {
        $stmt = self::query("
            SELECT d.* 
            FROM discounts d
            INNER JOIN items i ON i.discounts_id = d.id
            WHERE i.id = :id
        ", ['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function smallOptions($id)
    {
        $stmt = self::query("
            SELECT so.*
            FROM small_options so
            INNER JOIN items_small_options iso ON so.id = iso.small_option_id
            WHERE iso.item_id = :id
        ", ['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Создать новый товар с связями.
     *
     * @param string $title Название товара.
     * @param float $price Цена товара.
     * @param int $discountsId ID скидки.
     * @param array $smallOptionsIds Массив ID маленьких опций.
     * @return bool|int Возвращает ID нового товара или false в случае ошибки.
     */
    public static function create($title, $price, $discountsId = null, $smallOptionsIds = [])
    {
        $db = self::getDB();

        try {
            // Начало транзакции
            $db->beginTransaction();

            // Вставка нового товара
            $stmt = $db->prepare("
                INSERT INTO items (title, price, discounts_id)
                VALUES (:title, :price, :discounts_id)
            ");
            $stmt->execute([
                ':title' => $title,
                ':price' => $price,
                ':discounts_id' => $discountsId
            ]);

            // Получаем ID нового товара
            $itemId = $db->lastInsertId();

            // Установление связей с маленькими опциями (если указаны)
            if (!empty($smallOptionsIds)) {
                $stmt = $db->prepare("
                    INSERT INTO items_small_options (item_id, small_option_id)
                    VALUES (:item_id, :small_option_id)
                ");

                foreach ($smallOptionsIds as $smallOptionId) {
                    $stmt->execute([
                        ':item_id' => $itemId,
                        ':small_option_id' => $smallOptionId
                    ]);
                }
            }

            // Подтверждение транзакции
            $db->commit();

            return $itemId;
        } catch (Exception $e) {
            // Откат транзакции в случае ошибки
            $db->rollBack();
            throw new Exception("Ошибка при создании товара: " . $e->getMessage());
        }
    }
}