<?php

namespace App\Database;

abstract class Seeder
{
    /**
     * @var string Что-то )))
     */
    protected string $model;

    /**
     * Действие )))
     *
     * @return void
     */
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