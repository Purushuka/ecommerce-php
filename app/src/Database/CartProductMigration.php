<?php

namespace App\Database;

class CartProductMigration extends Migration
{

    public function up(): void
    {
        $this->createTable('cart_product');
        $this->createInt('cart_id');
        $this->createInt('product_id');
        $this->createForeignKey('cart_id','carts','id');
        $this->createForeignKey('product_id','products','id');
    }
}