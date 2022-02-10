<?php

namespace App;

class Request {
    private string $uri;
    private string $method;
    private array $content;

    const POST = 'POST';
    const GET = 'GET';

    public function __construct()
    {
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->content = $this->method === self::GET ? $_GET : $_POST;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }
}