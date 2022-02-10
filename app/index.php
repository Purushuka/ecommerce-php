<?php

require_once './vendor/autoload.php';
require_once './bootstrap.php';

$app = new \App\Application();
$app->boot();


//todo: ПОменять в ссылке id на slug, для этлоого в views(поменять ссылки на slug), в контролее использзовать метод where,

// todo: Сделать механизм редиректа