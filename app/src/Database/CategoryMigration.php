<?php

namespace App\Database;

class CategoryMigration extends Migration
{
    public function up(): void
    {
        $this->createTable('categories');

        $this->createVarchar('title', 25);
        $this->createVarchar('slug', 30);
        $this->createVarchar('description', 255);
    }
}