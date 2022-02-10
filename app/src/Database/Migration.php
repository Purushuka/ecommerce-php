<?php

namespace App\Database;

use App\DatabaseConnection;

abstract class Migration
{
    public string $table;
    public array $columns = [
        [
            'column_name' => 'id', 'type' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY'
        ]
    ];

    abstract public function up(): void;

    public static function run(array $migrations): void
    {
        $connection = (new DatabaseConnection())->getConnection();
        $connection->query('SET FOREIGN_KEY_CHECKS = 0');

        foreach ($migrations as $migration) {
            $table = new $migration();
            $table->up();

            $query = sprintf('DROP TABLE IF EXISTS %s;', $table->table);
            $connection->query($query);
            $columns = '';
            foreach ($table->columns as $column) {
                $column = implode(' ', $column);
                $columns .= $column . ',';
            }
            $columns = substr($columns, 0, -1);

            $sql = sprintf('CREATE TABLE %s (%s);', $table->table, $columns);

            $connection->query($sql);
        }

        $connection->query('SET FOREIGN_KEY_CHECKS = 1');
    }

    protected function createTable(string $name): void
    {
        $this->table = $name;
    }

    public function createInt(string $name)
    {
        $this->columns[] = [
            'column_name' => $name,
            'type' => 'int'
        ];
    }

    public function createVarchar(string $name, int $size)
    {
        $this->columns[] = [
            'column_name' => $name,
            'type' => sprintf('varchar(%s)', $size)
        ];
    }

    public function createForeignKey(string $name, string $table, string $columnName): void
    {
        $this->columns[] = [
            sprintf('FOREIGN KEY (%s) REFERENCES %s(%s) ON DELETE CASCADE', $name, $table, $columnName)
        ];
    }
}



//  CREATE TABLE IF NOT EXISTS categories (
//     id int primaryKey,
//     title varchar(25),
//     slug varchar(30)
//     description varchar(255),
// );

// products
//     REF category_id asdasdasd ON DELETE 'cascade'

// ON DELETE 'cascade'
