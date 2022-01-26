<?php

namespace Purushuka\Spotify\Models;

use Purushuka\Spotify\DatabaseConnection;

abstract class Model
{
    protected string $table;
    protected string $primaryKey;
    private DatabaseConnection $connection;

    public function __construct()
    {
        $this->connection = new DatabaseConnection();
    }

    public function exists(string $column, string $value): bool
    {
        return $this->connection->exists($this->table, $column, $value);
    }

    public function insert(array $data)
    {
        $this->connection->insert($this->table, $data);
    }

    public function find(string $value): array
    {
        return $this->connection->select($this->table, $this->primaryKey, $value);
    }

    public function where(string $column, string $value): array
    {
        return $this->connection->select($this->table, $column, $value);
    }
}