<?php

require_once './vendor/autoload.php';
require_once './bootstrap.php';

use Purushuka\Spotify\DatabaseConnection;

$db = new DatabaseConnection();

$dataset = [
    ['table'=> 'categories', 'data' => ['title' => '"Шишки"', 'description' => '"Лучшие шишки со всего мира"']],
    ['table'=> 'categories', 'data' => ['title' => '"Мишки"']],
    ['table'=> 'products', 'data' => ['title' => '"Кебабчик"']],
    ['table'=> 'products', 'data' => ['title' => '"Кебабчек"', 'price' => '"333"']],
    ['table'=> 'products', 'data' => ['title' => '"Тапочек"', 'description' => '"Что-то лучшее во всем мире"']],
];

foreach ($dataset as $item) {
    $db->insert($item['table'], $item['data']);
}
