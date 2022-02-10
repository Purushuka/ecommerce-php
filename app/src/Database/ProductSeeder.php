<?php

namespace App\Database;

use App\Models\Category;
use App\Models\Product;
use Cocur\Slugify\Slugify;

class ProductSeeder extends Seeder
{
    protected string $model = Product::class;

    protected function up(): void
    {
        $slug = new Slugify();
        $this->seed([
            'title' => 'Помидор',
            'slug' => $slug->slugify('Помидор'),
            'category_id' => Category::where('title', 'Овощи')[0]?->id,
            'price' => '300',
            'description' => 'Сеньер помидор'
        ]);

        $this->seed([
            'title' => 'Огурец',
            'slug' => $slug->slugify('Огурец'),
            'category_id' => Category::where('title', 'Овощи')[0]?->id,
            'price' => '300',
            'description' => 'Молосольный помидор'
        ]);

        $this->seed([
            'title' => 'Капуста',
            'slug' => $slug->slugify('Капуста'),
            'category_id' => Category::where('title', 'Овощи')[0]?->id,
            'price' => '300',
            'description' => 'Многослойная капуста'
        ]);

        $this->seed([
            'title' => 'Банан',
            'slug' => $slug->slugify('Банан'),
            'category_id' => Category::where('title', 'Фрукты')[0]?->id,
            'price' => '300',
            'description' => 'Большой Банан'
        ]);

        $this->seed([
            'title' => 'Яблоко',
            'slug' => $slug->slugify('Яблоко'),
            'category_id' => Category::where('title', 'Фрукты')[0]?->id,
            'price' => '555',
            'description' => 'Спелое яблоко'
        ]);

        $this->seed([
            'title' => 'Огурец без гмо',
            'slug' => $slug->slugify('Огурец без гмо'),
            'category_id' => Category::where('title', 'Овощи без гмо')[0]->id,
            'price' => '300',
            'description' => 'Молосольный помидор без гмо'
        ]);
        $this->seed([
            'title' => 'Капуста без гмо',
            'slug' => $slug->slugify('Капуста без гмо'),
            'category_id' => Category::where('title', 'Овощи без гмо')[0]->id,
            'price' => '300',
            'description' => 'Многослойная капуста без гмо'
        ]);
    }
}