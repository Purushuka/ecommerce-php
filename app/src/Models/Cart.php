<?php

namespace App\Models;

/**
 * @property int $id Идентификатор корзины
 */
class Cart extends Model
{
    protected string $table = 'carts';
    protected array $attributes = [
        'id'
    ];

    /**
     * Возвращает коллекцию моделей Product
     * @return array
     */
    public function products(): array
    {
        $cartProducts = CartProduct::where('cart_id', $this->id);
        $products = [];

        foreach ($cartProducts as $cartProduct) {
            $products[] = $cartProduct->product();
        }

        return $products;
    }

    /**
     * Возвращает сумму продуктов в корзине
     * @return int
     */
    public function amount(): int
    {
        $amount = 0;
        foreach ($this->products() as $product) {
            $amount += $product->price;
        }
        return $amount;
    }
}