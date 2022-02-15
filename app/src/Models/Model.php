<?php

namespace App\Models;

use App\DatabaseConnection;

/**
 * Базовая модель
 */
abstract class Model
{
    /** @var string Название таблицы */
    protected string $table;
    /** @var string Название поля id*/
    protected string $primaryKey = 'id';
    /**
     * @var array Массив с названиями стобцов для каждой из моделей
     */
    protected array $attributes = [];
    /**
     * @var array Массив для работы с магическими методами
     */
    private array $data = [];
    /**
     * @var DatabaseConnection Подключение к базе данных
     */
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
     * Возвращает модель записи из бд по определенному id
     * @param int $id передается значение стобца id
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
     *Создает запись в бд и запись в массиве $data
     * @param array $data массив из данных для создания таблицы
     * @return static
     */
    public static function create(array $data): static
    {
        $instance = new static();

        if ($instance->id = $instance->insert($data)) {
            foreach ($data as $key => $value) {
                $instance->$key = $value;
            }
        }

        return $instance;
    }

    /**
     * Возвращает массив из всех записей класса на котором была вызвана
     * @return array<static>
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
     * Возвращает bool значения в зависимости от наличия подобной записи в таблице
     * @param string $column название стобца
     * @param string $value значение в этом стобце
     * @return bool
     */
    public function exists(string $column, string $value): bool
    {
        return static::$connection->exists($this->table, $column, $value);
    }

    /**
     * Создает норвую запись в бд и возвращает последний id вставленной записи
     * @param array $data массив данных для создания записи
     * @return int|false
     */
    public function insert(array $data): int|false
    {
        return static::$connection->insert($this->table, $data);
    }

    /**
     * Возвращает одну запись модели
     * @param string $column
     * @param string $value
     * @return array<static>
     */
    public static function where(string $column, string $value): array
    {
        $instance = new static();
        $records = static::$connection->select($instance->table, $column, $value);
        return $instance->collection($records);
    }

    /**
     * Возвращает коллекцию моделей
     * @param string $column Название столбца
     * @param array $values Значение столбца
     * @return array<static>
     */
    public static function whereIn(string $column, array $values): array
    {
        $instance = new static();
        $records = static::$connection->select($instance->table, $column, $values);
        return $instance->collection($records);
    }

    /**
     * Вспомогательный метод для
     * @param array $records Массив который вернет функция select
     * @return array
     */

    private function collection(array $records): array
    {
        $instances = [];
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