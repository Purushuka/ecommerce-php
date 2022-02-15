<?php

namespace App\Models;

/**
 * Модель товара
 *
 * @property int $id Идентификатор товара
 * @property string $title Название товара
 */
class Product extends Model
{
    protected string $table = 'products';
    protected array $attributes = [
        'id', 'title', 'description', 'price', 'category_id', 'slug'
    ];
}