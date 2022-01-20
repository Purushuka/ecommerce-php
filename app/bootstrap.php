<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

const GET_REQUEST = 'GET';
const POST_REQUEST = 'POST';

const API_GET_CATEGORIES = 'categories';
const API_GET_PRODUCTS   = 'products';
const API_POST_CATEGORIES = 'postCategories';
const API_POST_PRODUCTS   = 'postProducts';


/**
 * Возвращает данные о запросе
 *
 * @return array
 */
function getRequest(): array
{
    $method = $_REQUEST['method'] ?? null;
    unset($_REQUEST['method']);

    $request = [
        'method' => $method, // null или string
        'data' => $_REQUEST  // null или array
    ];

    if ($_SERVER['REQUEST_METHOD'] === GET_REQUEST) {
        ////////
    } elseif ($_SERVER['REQUEST_METHOD'] === POST_REQUEST) {

        switch ($_REQUEST['type']) {
            case 'category':
                $request['method'] = API_POST_CATEGORIES;
                break;

            case 'product':
                $request['method'] = API_POST_PRODUCTS;
                break;
            default:

                break;
        }
    }
    return $request;
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
    }
    else {
        die('Database connection failed!');
    }
}