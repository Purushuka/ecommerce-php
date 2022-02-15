<?php

namespace App\Models;

class CartProduct extends Model
{
    protected string $table = 'cart_product';
    protected array $attributes = [
        'id', 'product_id', 'cart_id'
    ];

    public function cart(): Cart
    {
        return Cart::find($this->cart_id);
    }

    public function product(): Product
    {
        return Product::find($this->product_id);
    }
}