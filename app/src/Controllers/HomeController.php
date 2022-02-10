<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Request;

class HomeController extends Controller
{
    public function index(): void
    {
        $categories = Category::all();
        $products = Product::all();

        $this->render('index', compact('categories', 'products'));
    }

    public function search(Request $request): void
    {
        $categories = Category::all();
        $products = Product::all();

        $this->render('index', compact('categories', 'products'));
    }
}
