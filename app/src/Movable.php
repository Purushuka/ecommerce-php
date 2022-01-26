<?php

namespace Purushuka\Spotify;

abstract class Movable
{
    protected int $speed;
    protected string $name;

    public function move()
    {

        echo static::class . " Я еду со скоростью {$this->name}{$this->speed}";
    }
}