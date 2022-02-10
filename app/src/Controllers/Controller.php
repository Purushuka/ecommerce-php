<?php

namespace App\Controllers;

abstract class Controller
{
    private const VIEW_PATH = './resources/views/';

    protected function render(string $view, array $data = []): void
    {
        $file = self::VIEW_PATH . $view . '.php';

        if (file_exists($file)) {
            extract($data);

            require $file;
        }
    }
}