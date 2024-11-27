<?php
namespace App\Models;
use PDO;
use Core\Model;
use Exception;
/**
 * @property int $id
 * @property string $title
 * @property float $price
 * @property int|null $discounts_id
 */
class Item extends Model
{

    public $discounts_id = '';
    public $id = ''
    ;
    public static function all()
    {
        $stmt = self::query("SELECT * FROM items");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $stmt = self::query("SELECT * FROM items WHERE id = :id", ['id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result) {
            $item = new self();
            foreach ($result as $key => $value) {
                $item->$key = $value; // Инициализация свойств объекта
            }
            return $item;
        }

        return null;
    }

    public function discount()
    {
        if ($this->discounts_id === '') {
            return null; // Если поле не заполнено, возвращаем null
        }else{
            $stmt = self::query("SELECT * FROM discounts WHERE id = :id", ['id' => $this->discounts_id]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($result) {
                return (object) $result; // Преобразуем в объект для удобного обращения через ->
            }
        }
    }

    public function smallOptions()
    {
        if ($this->id === '') {
            throw new \Exception("ID товара не установлен.");
        }

        $stmt = self::query("
            SELECT so.*
            FROM small_options so
            INNER JOIN items_small_options iso ON so.id = iso.small_option_id
            WHERE iso.item_id = :id
        ", ['id' => $this->id]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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