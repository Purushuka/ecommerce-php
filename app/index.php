<?php

// http://localhost:8000/?method=categories&id=3&products=true

// Инициализация:
// 1. Получить данные из файлов /datasets/categories.php и /datasets/products.php
// 2. Обрабатываешь их и если таких записей нет в базе, то добавляешь

// 1. Заполнить функции getCategories и getProducts

require_once __DIR__ . '/bootstrap.php';

const API_CATEGORIES = 'categories';
const API_PRODUCTS   = 'products';

$request = getRequest();
$pdo     = getDatabaseConnection();

fillDatabase($pdo);

function fillDatabase(PDO $pdo)
{
    $categories = require __DIR__.'/datasets/categories.php';
    $products = require __DIR__.'/datasets/products.php';
    $existProducts = $pdo->prepare('SELECT * FROM products WHERE title=:title');
    $existCategories = $pdo->prepare('SELECT * FROM categories WHERE title=:title');

    foreach ($products as $product) {
        $existProducts->execute([
            'title' => $product['title']
        ]);

        if (! $existProducts->fetch()) {
            addProduct($product,$pdo);
        }
    }

    foreach ($categories as $category) {
        $existCategories->execute([
            'title' => $category['title']
        ]);

        if (! $existCategories->fetch()) {
            addCategory($category,$pdo);
        }
    }
}

function addCategory(array $category, PDO $pdo): void
{
    $addCategory = $pdo->prepare('INSERT INTO categories (title) VALUES(:title)');
    $addCategory->execute([
         'title' => $category['title']
    ]);
}

function addProduct(array $product, PDO $pdo): void
{
    $addProduct = $pdo->prepare('INSERT INTO products (title, category_id) VALUES(:title, :category_id)');
    $addProduct->execute([
        'title' => $product['title'],
        'category_id' => $product['category_id']
    ]);
}

function getCategories(?array $data): array
{
    global $pdo;
    // Возможные параметры:
    // [x]id - ?int идентификатор категории => Вернуть данные о категории под этим id, если она существует
    // products - bool (false по умолчанию), требует id если передан true => Вернуть товары из категории по id
    // [x] Если никакие параметры не переданы вернуть список всех категорий

    // Пример корректных параметров $data = ['id' => '3', 'products' => 'true']
    //        $getCategories = $pdo->prepare('SELECT * FROM categories WHERE id =:category_id');
    if($data['products']===true){
        if (isset($data['id'])) {
            $getProducts = $pdo->prepare('SELECT * FROM products WHERE id =:category_id');
            $getProducts->execute([
                'category_id' => $data['category_id']
            ]);
        }
        else
            echo 'НУ введи id плз';

    }
    if (isset($data['id'])) {
        $getCategories = $pdo->prepare('SELECT * FROM categories WHERE id =:category_id');
        $getCategories->execute([
            'category_id' => $data['id']
        ]);

        return $getCategories->fetchAll();
    }


    $getCategories = $pdo->prepare('SELECT * FROM categories ');
    $getCategories->execute();
    return $getCategories->fetchAll();

}

function getProducts(?array $data): array
{
    global $pdo;

    if (isset($data['id'])) {
        $getProducts = $pdo->prepare('SELECT * FROM products WHERE id =:product_id');
        $getProducts->execute([
            'product_id' => $data['id']
        ]);

        return $getProducts->fetchAll();
    }

    $getProducts = $pdo->prepare('SELECT * FROM products ');
    $getProducts->execute();
    return $getProducts->fetchAll();

    // Возможные параметры:
    // [x] id - ?int идентификатор товара => Вернуть данные о товаре под этим id, если он существует
    // [x]  Если никакие параметры не переданы вернуть список всех товаров

    // Пример корректных параметров $data = ['id' => '33']
}

switch ($request['method']) {
    case API_CATEGORIES:
        $result = getCategories($request['data']);
        break;
    case API_PRODUCTS:
        $result = getProducts($request['data']);
        break;
    default:
        //
        break;
}

if (isset($result)) {
    var_dump($result);
}