<?php

namespace App\Validators;

class ProductValidator
{
    protected $errors = [];

    /**
     * Выполнить валидацию данных.
     *
     * @param array $data Входные данные
     * @return bool true, если данные валидны, иначе false
     */
    public function validate(array $data): bool
    {
        $this->errors = []; // Сброс ошибок

        // Проверка поля product_name
        if (empty($data['product_name']) || !is_string($data['product_name'])) {
            $this->errors[] = "Название продукта обязательно и должно быть строкой.";
        }

        // Проверка поля price
        if (empty($data['price']) || !is_numeric($data['price']) || $data['price'] <= 0) {
            $this->errors[] = "Цена обязательна и должна быть положительным числом.";
        }

        // Проверка поля discount
        if (empty($data['discount']) || !is_numeric($data['discount'])) {
            $this->errors[] = "Скидка обязательна и должна быть числом.";
        }

        // Проверка поля small_option
        if (!isset($data['small_option']) || !is_array($data['small_option'])) {
            $this->errors[] = "Small options должны быть массивом.";
        } else {
            foreach ($data['small_option'] as $option) {
                if (!is_numeric($option) || $option <= 0) {
                    $this->errors[] = "Каждая small option должна быть положительным числом.";
                    break;
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Получить список ошибок валидации.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }
}