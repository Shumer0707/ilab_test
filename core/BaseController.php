<?php

namespace Core;

abstract class BaseController
{
    protected $config;

    public function __construct($config) {
        $this->config = $config;
    }

    protected function render($view, $data = [])
    {
        extract($data); // Преобразует массив в переменные
        require_once __DIR__ . '/../app/views/' . $view . '.php';
    }
}