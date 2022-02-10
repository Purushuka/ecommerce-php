<?php

namespace App\Models;

use App\DatabaseConnection;

abstract class Model
{
    /** @var string Название таблицы */
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $attributes = [];
    private array $data = [];
    private static DatabaseConnection $connection;

    private function __construct()
    {
        if (!isset(static::$connection)) {
            static::$connection = new DatabaseConnection();
        }
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    /**
     * @param string $name
     * @param        $value
     * @return void
     */
    public function __set(string $name, $value): void
    {
        if (in_array($name, $this->attributes)) {
            $this->data[$name] = $value;
        }
    }

    /**
     * Возвращает модель записи
     * @param int $id
     * @return static
     */
    public static function find(int $id): static
    {
        $instance = new static();

        if ($record = static::$connection->select($instance->table, $instance->primaryKey, $id)) {
            foreach ($record[0] as $key => $value) {
                $instance->$key = $value;
            }
        }

        return $instance;
    }

    /**
     *Создает запись в бд sql и запись в массиве $data
     * @param array $data
     * @return static
     */
    public static function create(array $data): static
    {
        $instance = new static();

        // generate SLUG
        // data['slug'] = '???';

        if ($instance->id = $instance->insert($data)) {
            foreach ($data as $key => $value) {
                $instance->$key = $value;
            }
        }

        return $instance;
    }

    /**
     * Хранит в переменной все записи выбранной таблицы
     * @return array
     */
    public static function all(): array
    {
        $instance = new static();
        $instances = [];
        $records = static::$connection->select($instance->table);


        foreach ($records as $index => $record) {
            $instances[$index] = new static();
            foreach ($record as $key => $value) {
                $instances[$index]->$key = $value;
            }
        }

        return $instances;
    }

    /**
     * Сохраняет изменения в бд после метода update
     * @return bool
     */
    public function save(): bool
    {
        return $this->update($this->data, $this->primaryKey, $this->id);
    }

    /**
     * Проверяет на наличие такой же записи в бд
     * @param string $column
     * @param string $value
     * @return bool
     */
    public function exists(string $column, string $value): bool
    {
        return static::$connection->exists($this->table, $column, $value);
    }

    /**
     * Создает норвую запись в бд
     * @param array $data
     * @return int|false
     */
    public function insert(array $data): int|false
    {
        return static::$connection->insert($this->table, $data);
    }

    /**
     * Ищет запись в таблице по определенному title
     * @param string $column
     * @param string $value
     * @return array
     */
    //todo: Сделать where так же как и all, и вынести foreach в отдельный метод(а может и не надо(подумай))

    public static function where(string $column, string $value): array
    {
        $instance = new static();
        $instances = [];
        $records = static::$connection->select($instance->table, $column, $value);
        foreach ($records as $index => $record) {
            $instances[$index] = new static();
            foreach ($record as $key => $value) {
                $instances[$index]->$key = $value;
            }
        }

        return $instances;
    }

    /**
     * Перезаписывает запись в бд
     * @param array $data
     * @param string $column
     * @param string $value
     * @return bool
     */
    public function update(array $data, string $column, string $value): bool
    {
        return static::$connection->update($this->table, $data, $column, $value);
    }
}