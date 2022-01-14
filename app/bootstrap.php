<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

/**
 * Возвращает данные о запросе
 *
 * @return array
 */
function getRequest(): array
{
    return [
        'method' => array_shift($_GET), // null или string
        'data'   => $_GET                     // null или array
    ];
}

/**
 * Возвращает подключение к базе данных
 *
 * @return PDO
 */
function getDatabaseConnection(): PDO
{
    $mysql = sprintf(
        "mysql:host=%s;port=%s;dbname=%s",
        $_ENV['DB_HOST'],
        $_ENV['DB_PORT'],
        $_ENV['DB_DATABASE']
    );

    if ($pdo = new PDO($mysql, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'])) {
        return $pdo;
    } else {
        die('Database connection failed!');
    }
}