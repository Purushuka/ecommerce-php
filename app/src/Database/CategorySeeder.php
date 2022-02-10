<?php

namespace App\Database;

use App\Models\Category;
use Cocur\Slugify\Slugify;

class CategorySeeder extends Seeder
{
    protected string $model = Category::class;

    protected function up(): void
    {
        $slug = new Slugify();

        $this->seed([
            'title' => 'Овощи',
            'slug' => $slug->slugify('Овощи'),
            'description' => 'Крутые овощи'
        ]);

        $this->seed([
            'title' => 'Фрукты',
            'slug' => $slug->slugify('Фрукты'),
            'description' => 'Крутые Фрукты'
        ]);

        $this->seed([
            'title' => 'Овощи без гмо',
            'slug' => $slug->slugify('Овощи без гмо'),
            'description' => 'Крутые овощи без гмо'
        ]);
    }
}