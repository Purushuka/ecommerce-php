<?php

namespace App;

use App\Controllers\BlogController;
use App\Controllers\CartController;
use App\Controllers\CategoryController;
use App\Controllers\ContactsController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;

class Router
{
    private static array $map = [
        '/'         => [
            'controller' => HomeController::class,
            'methods' => [
                'GET' => 'index',
                'POST' => 'search',
            ]
        ],

        '/contacts' => [
            'controller' => ContactsController::class,
            'methods' => [
                'GET' => 'index',
            ]
        ],

        '/category' => [
            'controller' => CategoryController::class,
            'methods' => [
                'GET' => 'index',
            ]
        ],
        '/blog' => [
            'controller' => BlogController::class,
            'methods' => [
                'GET' => 'index',
            ]
        ],
        '/product' => [
            'controller' => ProductController::class,
            'methods' => [
                'GET' => 'index',
                'POST' => 'add',
            ]
        ],

        '/cart' => [
            'controller' => CartController::class,
            'methods' => [
                'GET' => 'index',
            ]
        ],
    ];

    public static function run(): void
    {
        $request = new Request();

        $uri = $request->getUri();
        if(array_key_exists($uri, static::$map)) {
            if (array_key_exists($request->getMethod(), static::$map[$uri]['methods'])) {
                $controller = static::$map[$uri]['controller'];
                $action = static::$map[$uri]['methods'][$request->getMethod()];

                (new $controller)->$action($request);
            }
        } else {
            echo '404';
        }
    }
}