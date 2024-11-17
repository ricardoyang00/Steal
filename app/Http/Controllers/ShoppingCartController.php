<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;

use App\Models\Buyer;
use App\Models\Game;

class ShoppingCartController extends Controller
{
    public function index()
    {
        if (session()->has('buyer_id')) {
            $buyerId = session()->get('buyer_id');
            $shoppingCartItems = ShoppingCart::where('buyer', $buyerId)->get();
            $products = [];
            $total = 0;

            foreach ($shoppingCartItems as $item) {
                $game = Game::find($item->game);
                if ($game) {
                    $products[] = [
                        'id' => $game->id,
                        'name' => $game->name,
                        'price' => $game->price,
                        'quantity' => $item->quantity
                    ];
                }
                $total += $game->price * $item->quantity;
            }

            return view('pages.shopping_cart', ['products' => $products, 'total' => $total]);
        } else {
            return redirect()->route('login');
        }
    }

    public function increaseQuantity(Request $request)
    {
        $buyerId = session()->get('buyer_id');
        $gameId = $request->input('game_id');

        $shoppingCartItem = ShoppingCart::where('buyer', $buyerId)
                                        ->where('game', $gameId)
                                        ->first();

        if ($shoppingCartItem) {
            $shoppingCartItem->quantity += 1;
            $shoppingCartItem->save();
        }

        return redirect()->route('shopping_cart');
    }

    public function decreaseQuantity(Request $request)
    {
        $buyerId = auth_user()->id;
        $gameId = $request->input('game_id');

        $shoppingCartItem = ShoppingCart::where('buyer', $buyerId)
                                        ->where('game', $gameId)
                                        ->first();

        if ($shoppingCartItem) {
            $shoppingCartItem->quantity -= 1;
            if ($shoppingCartItem->quantity <= 0) {
                $shoppingCartItem->delete();
            } else {
                $shoppingCartItem->save();
            }
        }

        return redirect()->route('shopping_cart');
    }

    public function removeProduct(Request $request)
    {
        $buyerId = session()->get('buyer_id');
        $gameId = $request->input('game_id');

        $shoppingCartItem = ShoppingCart::where('buyer', $buyerId)
                                        ->where('game', $gameId)
                                        ->first();

        if ($shoppingCartItem) {
            $shoppingCartItem->delete();
        }

        return redirect()->route('shopping_cart');
    }
}