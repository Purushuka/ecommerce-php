<?php

namespace App\Models;

class Category extends Model
{
    protected string $table = 'categories';
    protected array $attributes = [
        'id', 'title', 'description'
    ];
}