<?php
namespace App\Models;
use PDO;
use Core\Model;

class Discount extends Model
{
    public static function all()
    {
        $stmt = self::query("SELECT * FROM discounts");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $stmt = self::query("SELECT * FROM discounts WHERE id = :id", ['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function items($id)
    {
        $stmt = self::query("SELECT * FROM items WHERE discounts_id = :id", ['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}