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

    /**
     * Запуск всех основных методов
     * @return void
     */
    public function boot(): void
    {
//        if ($_ENV['APP_STATE'] == 'debug') {
//            Migration::run([
//                CategoryMigration::class,
//                ProductsMigration::class,
//                CartMigration::class,
//                CartProductMigration::class
//            ]);
//
//            Seeder::run([
//                CategorySeeder::class,
//                ProductSeeder::class,
//                CartSeeder::class,
//                CartProductSeeder::class
//            ]);
//        }

        // Session here
        Router::run();
    }
}