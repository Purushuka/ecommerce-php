<?php

namespace App\Models;

class CartProduct extends Model
{
    protected string $table = 'cart_product';
    protected array $attributes = [
        'id', 'product_id', 'cart_id'
    ];

    /**
     * Возвращает модели класса cart по cart_id
     * @return Cart
     */
    public function cart(): Cart
    {
        return Cart::find($this->cart_id);
    }

    /**
     * Возвращает модели класса Product по product_id
     * @return Product
     */
    public function product(): Product
    {
        return Product::find($this->product_id);
    }
}