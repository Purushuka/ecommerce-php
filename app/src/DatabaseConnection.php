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

        if (! $this->connection = new PDO($mysql, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'])) {
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
     * @param string $table  Название таблицы
     * @param string $column Название столбца
     * @param string $value  Значение столбца
     *
     * @return bool
     */
    public function exists(string $table, string $column, string $value): bool
    {
        $query     = sprintf('SELECT %s FROM %s WHERE %s=:value', $column, $table, $column);
        $statement = $this->getConnection()->prepare($query);
        $statement->execute(['value' => $value]);

        return ! empty($statement->fetchAll());
    }

    /**
     * Добавляет запись в таблицу
     *
     * @param string $table
     * @param array  $data
     *
     * @return void
     */
    public function insert(string $table, array $data)
    {
        $columns   = implode(',', array_keys($data));
        $values    = implode(',', $data);
        $query     = sprintf('INSERT INTO %s(%s) VALUES(%s)', $table, $columns, $values);
        $statement = $this->getConnection()->prepare($query);
        $statement->execute();
    }

    /**
     * Ищет записи в таблице
     *
     * @param string      $table
     * @param string|null $column
     * @param string|null $value
     *
     * @return array
     */
    public function select(string $table, string $column = null, string $value = null): array
    {
        $query = sprintf('SELECT * FROM %s', $table);

        if ($column && $value) {
            $query .= sprintf(' WHERE %s="%s"', $column, $value);
        }

        $statement = $this->getConnection()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Обновляет существующую запись в таблице
     *
     * @param string $table
     * @param array  $data
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
}