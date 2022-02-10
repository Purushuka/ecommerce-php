<?php

namespace App\Models;

/**
 * @property int $id Идентификатор категории
 * @property string $title Название
 * @property string $description Описание
 */
class Category extends Model
{
    protected string $table = 'categories';
    protected array $attributes = [
        'id', 'title', 'description'
    ];

    public function products(): array
    {
        return Product::where('category_id', $this->id);
    }
}