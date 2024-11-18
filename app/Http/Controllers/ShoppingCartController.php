<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;

use App\Models\Buyer;
use App\Models\Game;
use App\Models\User;

class ShoppingCartController extends Controller
{

    public function index()
    {
        if (auth_user()){
            if (auth_user()->buyer()) {
                $buyerId = auth_user()->id;
                $shoppingCartItems = ShoppingCart::where('buyer', $buyerId)->get();
            } else {
                return redirect()->route('home');
            }
        } else {
            $shoppingCart = session('shopping_cart', []);
        }

        $products = [];
        $total = 0;

        if (auth_user()) {
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
        } else {
            foreach ($shoppingCart as $item) {
                $products[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity']
                ];
                $total += $item['price'] * $item['quantity'];
            }
        }

        return view('pages.shopping_cart', ['products' => $products, 'total' => $total]);
    }

    public function addProduct(Request $request, $gameId, $quantity = 1)
    {
        if (!auth_user()) {
            $shoppingCart = $request->session()->get('shopping_cart', []);

            if (isset($shoppingCart[$gameId])) {
                $shoppingCart[$gameId]['quantity'] += 1;
            } else {
                $game = Game::find($gameId);
                if ($game) {
                    $shoppingCart[$gameId] = [
                        'id' => $game->id,
                        'name' => $game->name,
                        'price' => $game->price,
                        'quantity' => 1
                    ];
                }
            }

            $request->session()->put('shopping_cart', $shoppingCart);

        } else {
            $buyerId = auth_user()->id;
    
            $shoppingCartItem = ShoppingCart::where('buyer', $buyerId)
                                            ->where('game', $gameId)
                                            ->first();
    
            if ($shoppingCartItem) {
                $shoppingCartItem->quantity += $quantity;
                $shoppingCartItem->save();
            } else {
                $shoppingCartItem = new ShoppingCart();
                $shoppingCartItem->buyer = $buyerId;
                $shoppingCartItem->game = $gameId;
                $shoppingCartItem->quantity = $quantity;
                $shoppingCartItem->save();
            }
    
        }
    }

    public function increaseQuantity(Request $request)
    {
        if (!auth_user()) {
            $gameId = $request->input('game_id');
            $shoppingCart = $request->session()->get('shopping_cart', []);

            if (isset($shoppingCart[$gameId])) {
                $shoppingCart[$gameId]['quantity'] += 1;
            } else {
                $game = Game::find($gameId);
                if ($game) {
                    $shoppingCart[$gameId] = [
                        'id' => $game->id,
                        'name' => $game->name,
                        'price' => $game->price,
                        'quantity' => 1
                    ];
                }
            }

            $request->session()->put('shopping_cart', $shoppingCart);

            return redirect()->route('shopping_cart');

        } else {
            $buyerId = auth_user()->id;
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
    }

    public function decreaseQuantity(Request $request)
    {
        if (!auth_user()) {
            $gameId = $request->input('game_id');
            $shoppingCart = $request->session()->get('shopping_cart', []);

            if (isset($shoppingCart[$gameId])) {
                if ($shoppingCart[$gameId]['quantity'] > 1) {
                    $shoppingCart[$gameId]['quantity'] -= 1;
                } else {
                    unset($shoppingCart[$gameId]);
                }
            } 

            $request->session()->put('shopping_cart', $shoppingCart);

            return redirect()->route('shopping_cart');
        } else {
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
    }

    public function removeProduct(Request $request)
    {
        if (!auth_user()) {
            $gameId = $request->input('game_id');
            $shoppingCart = $request->session()->get('shopping_cart', []);

            if (isset($shoppingCart[$gameId])) {
                unset($shoppingCart[$gameId]);
            }

            $request->session()->put('shopping_cart', $shoppingCart);

            return redirect()->route('shopping_cart');

        } else {
            $buyerId = auth_user()->id;
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

    public function mergeShoppingCart(Request $request, $shoppingCart)
    {
        $buyerId = auth_user()->id;
        
        foreach ($shoppingCart as $product) {
            $this->addProduct($request, $product['id'], $product['quantity']);
        }

    }

    public function addTestProducts(Request $request)
    {
        $request->session()->put('shopping_cart', []);

        $gameIds = [1, 2, 3];

        foreach ($gameIds as $gameId) {
            $this->addProduct($request, $gameId);
        }

        return redirect()->route('home');

    }
}