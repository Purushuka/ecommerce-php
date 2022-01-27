<?php

use App\Models\Category;

require_once './vendor/autoload.php';
require_once './bootstrap.php';

class Test {
    private array $data = [];

    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->data[$name] = $value;
    }

    public static function find(int $id)
    {
        $instance = new static();

        $record = [
            'id' => $id,
            'title' => 'Shishka',
            'description' => 'Description'
        ];
        foreach ($record as $key => $value) {
            $instance->$key = $value;
        }

        return $instance;
    }
}


$test = new Test();

//$test->lmao;
//$test->lmao = 25;
//$test->lmao = 500;

$finder = Test::find(40);


$category = Category::find(40);
$category->title = 'САМЫЕ ЛУЧШИЕ ШИШКИ';
$category->description = 'Лул кек';
$category->save();

dump($category);