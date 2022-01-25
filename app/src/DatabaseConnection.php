<?php

namespace Purushuka\Spotify;

use PDO;


class DatabaseConnection
{
    // Создать приватное свойство содержащее экземпляр PDO
    // Добавить метод exists
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
     * @param string $table Название таблицы
     * @param string $column Название столбца
     * @param string $value Значение столбца
     * @return bool
     */
    public function exists(string $table, string $column, string $value): bool
    {
        $query = sprintf('SELECT %s FROM %s WHERE %s=:value', $column, $table, $column);
        $statement = $this->getConnection()->prepare($query);
        $statement->execute(['value' => $value]);

        return !empty($statement->fetchAll());
    }

    public function insert(string $table, array $data)
    {
        //['table'=> 'categories', 'data' => ['title' => 'Шишки', 'description' => 'Лучшие шишки со всего мира']],
        $columns = implode(',', array_keys($data));
        $values = implode(',', $data);

//        foreach ($data as $key => $item) {
//            $columns .= $key . ',';
//            $values .= $item . ',';
//        }
//        $columns = substr_replace($columns, '', strlen($columns) - 1);
//        $values = substr_replace($values,'',strlen($values)-1);

        $query = sprintf('INSERT INTO %s(%s) VALUES(%s)', $table, $columns, $values);
        $statement = $this->getConnection()->prepare($query);
        $statement->execute();
    }
}