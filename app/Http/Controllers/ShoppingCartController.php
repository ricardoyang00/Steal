<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function index()
    {
        $cartItems = ShoppingCart::with('game')->get();
        return view('shopping_cart', compact('cartItems'));
    }

    public function add(Request $request)
    {
        // Add item to cart logic
    }
}