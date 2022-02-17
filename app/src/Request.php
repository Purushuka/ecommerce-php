<?php

namespace App;

class Request
{
    private string $uri;
    private string $method;
    private array $content;

    const POST = 'POST';
    const GET = 'GET';
    const DELETE = 'DELETE';

    public function __construct()
    {
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->content = $this->content();
    }

    /**
     * Возвращает uri
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Возвращает метод
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Возвращает контент
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }

    private function content(): array
    {
        $content = [];

        switch ($this->method) {
            case self::GET:
                $content = $_GET;
                break;
            case self::POST:
                $content = $_POST;
                break;
            case self::DELETE;
                parse_str(file_get_contents("php://input"), $content);
                break;
        }

        return $content;
    }
}