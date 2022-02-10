<?php

namespace App\Models;

class Product extends Model
{
    protected string $table = 'products';
    protected array $attributes = [
        'id', 'title', 'description', 'price', 'category_id'
    ];
}