<?php

namespace App\Database;

abstract class Seeder
{
    protected string $model;

    abstract protected function up(): void;

    public static function run(array $seeders): void
    {
        foreach ($seeders as $seeder) {
            (new $seeder)->up();
        }
    }

    protected function seed(array $data): void
    {
        $this->model::create($data);
    }
}