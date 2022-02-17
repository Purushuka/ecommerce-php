<?php

namespace App;

use PDO;

class DatabaseConnection
{
    /**
     * @var PDO Подключение к базе данных
     */
    private PDO $connection;

    public function __construct()
    {
        $mysql = sprintf(
            "mysql:host=%s;port=%s;dbname=%s",
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'],
            $_ENV['DB_DATABASE']
        );

        if (!$this->connection = new PDO($mysql, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'])) {
            die('Нет подключения');
        }

        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_NAMED);
    }

    /**
     * Возвращает подключение к базе данных
     *
     * @return PDO Подключение к базе данных
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Проверяет существование записи в таблице
     *
     * @param string $table Название таблицы
     * @param string $column Название столбца
     * @param string $value Значение столбца
     *
     * @return bool
     */
    public function exists(string $table, string $column, string $value): bool
    {
        $query = sprintf('SELECT %s FROM %s WHERE %s=:value', $column, $table, $column);
        $statement = $this->getConnection()->prepare($query);
        $statement->execute(['value' => $value]);

        return !empty($statement->fetchAll());
    }

    /**
     * Добавляет запись в таблицу
     *
     * @param string $table
     * @param array $data
     *
     * @return int|false
     */
    public function insert(string $table, array $data): int|false
    {
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_map(fn($v) => sprintf('"%s"', $v), $data));
        $query = sprintf('INSERT INTO %s(%s) VALUES(%s)', $table, $columns, $values);
        $this->getConnection()->prepare($query)->execute();

        return $this->getConnection()->lastInsertId();
    }

    /**
     * Ищет записи в таблице
     *
     * @param string $table
     * @param string|null $column
     * @param string|array|null $values
     * @return array
     */
    public function select(string $table, string $column = null, string|array $values = null): array
    {
        $query = sprintf('SELECT * FROM %s', $table);

        if ($column && $values) {
            if (is_string($values)) {
                $query .= sprintf(' WHERE %s="%s"', $column, $values);
            } elseif (is_array($values)) {
                $query .= sprintf(' WHERE %s IN (%s)', $column, implode(',', array_map(fn($v) => "$v", $values)));
            }
        }

        $statement = $this->getConnection()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Обновляет существующую запись в таблице
     *
     * @param string $table
     * @param array $data
     * @param string $column
     * @param string $value
     *
     * @return bool
     */
    public function update(string $table, array $data, string $column, string $value): bool
    {
        $values = implode(',', array_map(function ($key, $val) {
            return sprintf('%s="%s"', $key, $val);
        }, array_keys($data), array_values($data)));

        $query = sprintf('UPDATE %s SET %s WHERE %s="%s"', $table, $values, $column, $value);
        // UPDATE categories SET title="new Title",description="newDescription" WHERE id=40
        $statement = $this->getConnection()->prepare($query);

        return $statement->execute();
    }

    public function delete(string $table, string $column = null, string|array $values = null): void
    {
        $query = sprintf('DELETE FROM %s', $table);

        if ($column && $values) {
            if (is_string($values)) {
                $query .= sprintf(' WHERE %s="%s"', $column, $values);
            } elseif (is_array($values)) {
                $query .= sprintf(' WHERE %s IN (%s)', $column, implode(',', array_map(fn($v) => "$v", $values)));
            }
        }

        $statement = $this->getConnection()->prepare($query);
        $statement->execute();
    }

    // todo: вынести конструкцию WHERE в отдельный метод
}