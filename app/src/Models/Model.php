<?php

namespace App\Models;

use App\DatabaseConnection;

abstract class Model
{
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $attributes = [];
    private static DatabaseConnection $connection;

    public function __construct()
    {
        if (! isset(static::$connection)) {
            static::$connection = new DatabaseConnection();
        }
    }

    public function __get(string $name)
    {
        echo "Вызываем несуществующее свойство $name";
    }

    public function __set(string $name, $value): void
    {
        echo "Пытаемся записать в несуществующее свойство $name - значение $value";
    }

    public function find(string $value): array
    {
        return static::$connection->select($this->table, $this->primaryKey, $value);
    }

    public function exists(string $column, string $value): bool
    {
        return static::$connection->exists($this->table, $column, $value);
    }

    public function insert(array $data)
    {
        static::$connection->insert($this->table, $data);
    }

    public function where(string $column, string $value): array
    {
        return static::$connection->select($this->table, $column, $value);
    }

    public function update(array $data, string $column = null, string $value = null):bool
    {
        return static::$connection->update($this->table, $data, $column, $value);
    }

    private function isColumnExist(string $column): bool
    {
        return array_search($column, $this->attributes);
    }
}