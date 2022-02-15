<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::where('slug', $request->getContent()['slug'])[0];
        $products = Product::all();
        $categories = Category::all();

        $this->render('product', compact('product', 'products', 'categories'));
    }

    public function add(Request $request)
    {
        var_dump($request->getContent());
        return json_encode(['test' => 'data']);

//        $product = Product::where('id', $request->getContent()['id'])[0];
//        $products = Product::all();
//        $categories = Category::all();
//
//        $this->render('product', compact('product', 'products', 'categories'));
    }
}