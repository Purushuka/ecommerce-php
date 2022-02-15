<?php

namespace App\Database;

class CartMigration extends Migration
{

    public function up(): void
    {
        $this->createTable('carts');
        $this->createInt('amount');
    }
}