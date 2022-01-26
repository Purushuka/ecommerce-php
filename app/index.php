<?php

use Purushuka\Spotify\Models\Category;

require_once './vendor/autoload.php';
require_once './bootstrap.php';

$categoryModel = new Category();

$category=$categoryModel->find(3);
//dump($category);
//$category1 = $categoryModel->where('lolkek_ya_hacker_322', 'Шишкебабчик');


$columns = [
    'id', 'title', 'descriptions'
];

$bool = array_search('title', $columns);

dump($bool);