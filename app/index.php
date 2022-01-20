<?php

// http://localhost:8000/?method=categories&id=3&products=true

// Инициализация:
// [x] 1. Получить данные из файлов /datasets/categories.php и /datasets/products.php
// [x] 2. Обрабатываешь их и если таких записей нет в базе, то добавляешь

// [x] 1. Заполнить функции getCategories и getProducts
// [ ] 2. На каждый ендпоинт сделать возможность добавлять данные (новые категории, товары)

require_once __DIR__ . '/bootstrap.php';

$request = getRequest();
$pdo = getDatabaseConnection();

fillDatabase($pdo);

function isRecordExist(string $table, string $column, string $value, PDO $pdo): bool
{
    $query = sprintf('SELECT * FROM %s WHERE %s=:value', $table, $column);
    $statment = $pdo->prepare($query);
    $statment->execute(['value' => $value]);

    return !empty($statment->fetchAll());
}

function fillDatabase(PDO $pdo)
{
    $categories = require __DIR__ . '/datasets/categories.php';
    $products = require __DIR__ . '/datasets/products.php';

    foreach ($products as $product) {
        if (!isRecordExist('products', 'title', $product['title'], $pdo)) {
            addProduct($product, $pdo);
        }
    }

    foreach ($categories as $category) {
        if (!isRecordExist('categories', 'title', $category['title'], $pdo)) {
            addCategory($category, $pdo);
        }
    }
}

function addCategory(array $category, PDO $pdo): void
{
    if (!isRecordExist('categories', 'title', $category['title'], $pdo)) {
        $addCategory = $pdo->prepare('INSERT INTO categories (title) VALUES(:title)');
        $addCategory->execute([
            'title' => $category['title']
        ]);
    }
    else {
        echo 'Категория с таким' . $category['title'] . 'уже существует';
    }

}

function addProduct(array $product, PDO $pdo): void
{

    if (!isRecordExist('products', 'title', $product['title'], $pdo)) {
        if (isset($product['category_id']) && isRecordExist('categories', 'id', $product['category_id'], $pdo )) {
            $addProduct = $pdo->prepare('INSERT INTO products (title, category_id) VALUES(:title, :category_id)');
            $addProduct->execute([
                'title' => $product['title'],
                'category_id' => $product['category_id'] ?? null
            ]);
        } else {
            echo 'Категория с ID: ' . $product['category_id'] . ' не существует';
        }
    }
    else {
        echo 'Продукт с таким' . $product['title'] . 'уже существует';
    }
}

function getCategories(?array $data): array
{
    global $pdo;
    // Возможные параметры:
    // [x]id - ?int идентификатор категории => Вернуть данные о категории под этим id, если она существует
    // [x]products - bool (false по умолчанию), требует id если передан true => Вернуть товары из категории по id
    // [x] Если никакие параметры не переданы вернуть список всех категорий

    // Пример корректных параметров $data = ['id' => '3', 'products' => 'true']
    //        $getCategories = $pdo->prepare('SELECT * FROM categories WHERE id =:category_id');

    if (isset($data['products']) && $data['products'] === 'true') {
        if (isset($data['id'])) {
            $getProducts = $pdo->prepare('SELECT * FROM products WHERE category_id =:category_id');
            $getProducts->execute([
                'category_id' => $data['id']
            ]);
            return fetchAll($getProducts);
        }
        else
            echo 'НУ введи id плз';

    }
    elseif (isset($data['id'])) {
        $getCategories = $pdo->prepare('SELECT * FROM categories WHERE id =:category_id');
        $getCategories->execute([
            'category_id' => $data['id']
        ]);

        return fetchAll($getCategories);
    }

    $getCategories = $pdo->prepare('SELECT * FROM categories ');
    $getCategories->execute();
    return fetchAll($getCategories);
}

function getProducts(?array $data): array
{
    global $pdo;

    if (isset($data['id'])) {
        $getProducts = $pdo->prepare('SELECT * FROM products WHERE id =:product_id');
        $getProducts->execute([
            'product_id' => $data['id']
        ]);

        return fetchAll($getProducts);
    }

    $getProducts = $pdo->prepare('SELECT * FROM products ');
    $getProducts->execute();
    return fetchAll($getProducts);
}

function fetchAll(PDOStatement $statement): array
{
    return $statement->fetchAll(PDO::FETCH_NAMED);
}

switch ($request['method']) {
    case API_GET_CATEGORIES:
        $result = getCategories($request['data']);
        break;
    case API_GET_PRODUCTS:
        $result = getProducts($request['data']);
        break;
    case API_POST_CATEGORIES:
        $result = addCategory($request['data'], $pdo);
        break;
    case API_POST_PRODUCTS:
        $result = addProduct($request['data'], $pdo);
        break;

    default:
        //
        break;
}

if (isset($result)) {
    var_dump($result);
}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<div style="width: 400px; margin: 0 auto">
    <form action="index.php" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Awesome Title">
        </div>
        <div class="form-group">
            <label for="category_id">Category ID</label>
            <input type="number" class="form-control" id="category_id" name="category_id" placeholder="3" min="1">
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control" id="type" name="type">
                <option value="category">Category</option>
                <option value="product">Product</option>
            </select>
        </div>
        <div class="form-group">
            <input type="submit">
        </div>
    </form>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>

