<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function index()
    {
        $shoppingCart = ShoppingCart::all();
        return view('pages/shopping_cart');
    }
}