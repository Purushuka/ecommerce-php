<?php

namespace App\Controllers;

use App\Application;

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {
        $file = Application::VIEW_PATH . '/' . $view . '.php';

        if (file_exists($file)) {
            extract($data);

            require $file;
        }
    }
}