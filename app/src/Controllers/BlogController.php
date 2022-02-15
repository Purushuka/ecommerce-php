<?php

namespace App\Controllers;

class BlogController extends Controller
{
    public function index(): void{
        $this->render('blog');
    }
}