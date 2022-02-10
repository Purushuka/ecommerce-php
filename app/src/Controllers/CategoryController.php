<?php

namespace App\Controllers;

use App\Models\Category;
use App\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $category = Category::find($request->getContent()['id']);

        $this->render('category', compact('categories', 'category'));
    }
}

// http://localhost/categosdfg