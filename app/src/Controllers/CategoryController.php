<?php

namespace App\Controllers;

use App\Models\Category;
use App\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $category = Category::where('slug',$request->getContent()['slug'])[0];
        dump($category);

        $this->render('category', compact('categories', 'category'));
    }
}

// http://localhost/categosdfg