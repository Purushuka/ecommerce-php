<?php

require_once './vendor/autoload.php';
require_once './bootstrap.php';

$category = \App\Models\Category::find(1);
dd($category);