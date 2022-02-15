<?php

namespace App\Database;

use App\Models\CartProduct;

class CartProductSeeder extends Seeder
{
    protected string $model = CartProduct::class;

    /**
     * @inheritdoc
     */
    protected function up(): void
    {
        $this->seed([
            'product_id' => '1',
            'cart_id' => '1'
        ]);
        $this->seed([
            'product_id' => '2',
            'cart_id' => '1'
        ]);
    }
}