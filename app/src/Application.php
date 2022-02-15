<?php

namespace App;

use App\Database\{CartMigration,
    CartProductMigration,
    CartProductSeeder,
    CartSeeder,
    CategoryMigration,
    CategorySeeder,
    Migration,
    ProductSeeder,
    ProductsMigration,
    Seeder};

class Application
{
    public const VIEW_PATH = './resources/views';
    public const CSS_PATH = './resources/css';
    public const JS_PATH = './resources/js';

    public function boot(): void
    {
        Migration::run([
            CategoryMigration::class,
            ProductsMigration::class,
            CartMigration::class,
            CartProductMigration::class
        ]);

        Seeder::run([
            CategorySeeder::class,
            ProductSeeder::class,
            CartSeeder::class,
            CartProductSeeder::class

        ]);

        Router::run();
    }
}