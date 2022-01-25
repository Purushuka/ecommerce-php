<?php

namespace Purushuka\Spotify;

class Foo {
    private string $example;

    public function __construct(string $param){
        $this->example = $param;

    }
    public function getExample(): string
    {
        return $this->example;
    }
    public function setExample(string $data): void
    {
        $this->example = $data;
    }


}