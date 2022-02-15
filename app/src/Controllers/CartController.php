<?php

namespace App\Controllers;

use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::find(1);

        $this->render('cart', compact('cart'));
    }
}