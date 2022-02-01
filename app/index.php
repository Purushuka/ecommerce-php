<?php

use App\Models\Category;

require_once './vendor/autoload.php';
require_once './bootstrap.php';


// google.com.ru/q=ГорячиеМилфы
$test = Category::where('title','zalupa');
//$test2 = Category::all();
dd($test);