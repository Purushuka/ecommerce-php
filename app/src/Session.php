<?php

namespace App;

class Session {
    public function __construct()
    {
        session_start();
    }
}