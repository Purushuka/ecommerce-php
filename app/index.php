<?php

require_once './vendor/autoload.php';
require_once './bootstrap.php';

$app = new \App\Application();
$app->boot();

// todo: Сделать метод для вывода случайных моделей (Model) на основе all

// todo: Добавить функционал в метод where для того что бы можно было искать по нескольких стобцам, сначала сохраняем куда то SQL код, а потом весь этот набор выполняем отдельным методом
// todo: Паттерн строитель (Builder)

// Хранить в сессии ключ 'cart_id' со значением идентификатора корзины $_SESSION['cart_id'] = Cart::create()->id
// Выводить корзину для текущей сессии


// SELECT * FROM cart_product WHERE product_id=2
// SELECT * FROM cart_product WHERE product_id=2 AND cart_id=1 OR cart_id=3
// SELECT * FROM cart_product WHERE product_id=2 AND NOT cart_id=1

// CartProduct::where('product_id', 2)->where('cart_id', 3)->execute();