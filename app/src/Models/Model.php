<?php

namespace App\Models;

use App\DatabaseConnection;

abstract class Model
{
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $attributes = [];
    private array $data = [];
    private static DatabaseConnection $connection;

    private function __construct()
    {
        if (! isset(static::$connection)) {
            static::$connection = new DatabaseConnection();
        }
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    /**
     * @param string $name
     * @param        $value
     *
     * @return void
     */
    public function __set(string $name, $value): void
    {
        if (array_search($name, $this->attributes)) {
            $this->data[$name] = $value;
        }
    }

    /**
     * Возвращает модель записи
     *
     * @param int $id
     *
     * @return static|null
     */
    public static function find(int $id): ?self
    {
        $instance = new static();
        if ($record = static::$connection->select($instance->table, $instance->primaryKey, $id)) {
            foreach ($record[0] as $key => $value) {
                $instance->$key = $value;
            }
        }
        return $instance;
    }

    public function save(): bool
    {
        return $this->update($this->data, $this->primaryKey, $this->id);
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

    public function update(array $data, string $column = null, string $value = null): bool
    {
        return static::$connection->update($this->table, $data, $column, $value);
    }

    private function isColumnExist(string $column): bool
    {
        return array_search($column, $this->attributes);
    }
}