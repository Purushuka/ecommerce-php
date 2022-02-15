<?php

require_once './vendor/autoload.php';
require_once './bootstrap.php';

$app = new \App\Application();
$app->boot();

//dump(\App\Models\Product::all());
// 1. Сделать контроллер для корзины CartController -> cart



// todo: Сделать метод для вывода случайных моделей (Model) на основе all


// products      -> id, title
// carts         -> id, amount

// cart_product -> id, product_id, cart_id (pivot table)

// cart     - 1
// product  - 3,4,5

// product_cart: id=1, product_id=3, cart_id=1
// product_cart: id=1, product_id=4, cart_id=1
// product_cart: id=1, product_id=5, cart_id=1

// Cart -> product_cart(where cart_id=my_id) -> products (where id in(3,4,5))

// SELECT * FROM products WHERE IN id=[3,4,5]
// whereIn(string $column, array $values)

// 0. Сделать метод whereIn() для базовой модели
// 1. Создать миграцию для пивот таблицы 'cart_product'
// 2. Создать в моделе Cart метод для получения товаров через пивот таблицу

class Factory {
    public bool $work = false;

    public function getInfo(): bool
    {
        return $this->work;
    }

    public static function createString(array $array): string
    {
        return implode(',', $array);
    }
}

$factory1 = new Factory();
$factory2 = new Factory();
$factory3 = new Factory();

$factory2->work = true;

$string = Factory::createString(['123', '123', '123']);
$inst = \App\Models\Category::find(3);