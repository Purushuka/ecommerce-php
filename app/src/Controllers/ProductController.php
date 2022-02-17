<?php

namespace App\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
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
        $cart = Cart::find(1);
        $productId = $request->getContent()['id'];
        CartProduct::create(['cart_id' => $cart->id, 'product_id' => $productId]);
    }

    public function delete(Request $request)
    {
        $product = CartProduct::where('product_id', $request->getContent()['product_id'])[0];
        $product->delete();
    }
}



