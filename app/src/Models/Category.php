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
        'id', 'title','slug', 'description'
    ];

    /**
     * Возвращает массив моделей класса Product на экземляре класса Category
     * @return array
     */
    //todo: Спросить почему тут буду находиться все модели, а не с определенным
    public function products(): array
    {
        return Product::where('category_id', $this->id);
    }
}