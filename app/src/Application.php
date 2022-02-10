<?php

namespace App;

use App\Database\{CategoryMigration, CategorySeeder, Migration, ProductSeeder, ProductsMigration, Seeder};

class Application
{
    public function boot(): void
    {
        Migration::run([
            CategoryMigration::class,
            ProductsMigration::class
        ]);

        Seeder::run([
            CategorySeeder::class,
            ProductSeeder::class
        ]);

        Router::run();
    }
}