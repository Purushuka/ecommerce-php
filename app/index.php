<?php

require_once __DIR__ . '/bootstrap.php';

const API_CATEGORIES = 'categories';
const API_PRODUCTS   = 'products';

$request = getRequest();
$db      = getDatabaseConnection();

var_dump($request);

// http://localhost:8000/?method=categories&id=2&products=true

// Инициализация:
// 1. Получить данные из файлов /datasets/categories.php и /datasets/products.php
// 2. Обрабатываешь их и если таких записей нет в базе, то добавляешь

// 1. Заполнить функции getCategories и getProducts


function addCategory(array $category): void
{
    // Создает запись в бд
}

function addProduct(array $product): void
{
    // Создает запись в бд
}

function getCategories(?array $data): array
{
    // Возможные параметры:
    // id - ?int идентификатор категории => Вернуть данные о категории под этим id, если она существует
    // products - bool (false по умолчанию), требует id если передан true => Вернуть товары из категории по id
    // Если никакие параметры не переданы вернуть список всех категорий

    // Пример корректных параметров $data = ['id' => '3', 'products' => 'true']
}

function getProducts(?array $data): array
{
    // Возможные параметры:
    // id - ?int идентификатор товара => Вернуть данные о товаре под этим id, если он существует
    // Если никакие параметры не переданы вернуть список всех товаров

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