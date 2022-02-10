<?php

namespace App\Database;

class ProductsMigration extends Migration
{
    public function up(): void
    {
        $this->createTable('products');
        $this->createInt('category_id');
        $this->createInt('price');
        $this->createVarchar('title',25);
        $this->createVarchar('slug',30);
        $this->createVarchar('description',255);
        $this->createForeignKey('category_id','categories','id');
    }
}