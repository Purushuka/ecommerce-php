<?php

namespace App\Database;

use App\Models\Cart;

class CartSeeder extends Seeder
{
    protected string $model = Cart::class;

    protected function up(): void
    {
        $this->seed([
            'amount' => '5'
        ]);
    }
}