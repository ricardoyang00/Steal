<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;

use App\Models\Buyer;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ShoppingCartController extends Controller
{

    public function index()
    {
        if (auth_user()){
            if (auth_user()->buyer) {
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
                $game = Game::with(['platforms'])->find($item->game);
                if ($game && $game->is_active) {
                    $products[] = [
                        'id' => $game->id,
                        'name' => $game->name,
                        'price' => $game->price,
                        'stock' => $game->getStockAttribute(),
                        'quantity' => $item->quantity,
                        'release_date' => $game->release_date,
                        'thumbnail_small_path' => $game->getThumbnailSmallPath(),
                        'is_active' => $game->is_active,
                        'platforms' => $game->platforms->map(function($platform) {
                            return [
                                'id' => $platform->id,
                                'name' => $platform->name
                            ];
                        })->toArray(),
                    ];
                    $total += $game->price * $item->quantity;
                } else {
                    // Remove inactive game from the shopping cart
                    $item->delete();
                }
            }
        } else {
            foreach ($shoppingCart as $key => $item) {
                $game = Game::with(['platforms'])->find($item['id']);
                if ($game && $game->is_active) {
                    $products[] = [
                        'id' => $item['id'],
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'stock' => $game->getStockAttribute(),
                        'quantity' => $item['quantity'],
                        'release_date' => $item['release_date'],
                        'thumbnail_small_path' => $game->getThumbnailSmallPath(),
                        'is_active' => $game->is_active,
                        'platforms' => $game->platforms->map(function($platform) {
                            return [
                                'id' => $platform->id,
                                'name' => $platform->name
                            ];
                        })->toArray(),
                    ];
                    $total += $item['price'] * $item['quantity'];
                } else {
                    // Remove inactive game from the session shopping cart
                    unset($shoppingCart[$key]);
                }
            }
            session(['shopping_cart' => $shoppingCart]);
        }

        ksort($products);

        return view('pages.shopping_cart', ['products' => $products, 'total' => $total]);
    }

    public function addProduct(Request $request, $gameId = null, $quantity = 1)
    {
        if (!auth_user()) {
            $shoppingCart = $request->session()->get('shopping_cart', []);

            if (!$gameId) {
                $gameId = $request->input('game_id');
            }

            $game = Game::find($gameId);
            if (!$game || !$game->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'This game is no longer available.'
                ]);
            }

            if (isset($shoppingCart[$gameId])) {
                return $this->increaseQuantity($request);
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

            return response()->json([
                'success' => true,
            ]);

        } else {
            $buyerId = auth_user()->id;

            if (!$gameId) {
                $gameId = $request->input('game_id');
            }

            $game = Game::find($gameId);
            if (!$game || !$game->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'This game is no longer available.'
                ]);
            }

            $shoppingCartItem = ShoppingCart::where('buyer', $buyerId)
                                            ->where('game', $gameId)
                                            ->first();

            if ($shoppingCartItem) {
                for ($i = 0; $i < $quantity; $i++) {
                    if ($this->increaseQuantity($request)->getData()->success === false) {
                        return response()->json([
                            'success' => false,
                            'quantity_limit' => true,
                            'message' => 'You can only buy up to 10 copies of a game.'
                        ]);
                    }
                }
                $shoppingCartItem->save();
            } else {
                $shoppingCartItem = new ShoppingCart();
                $shoppingCartItem->buyer = $buyerId;
                $shoppingCartItem->game = $gameId;
                $shoppingCartItem->quantity = $quantity;
                $shoppingCartItem->save();
            }

            return response()->json([
                'success' => true,
            ]);
    
        }
    }

    public function increaseQuantity(Request $request)
    {
        if (!auth_user()) {
            $gameId = $request->input('game_id');
            $shoppingCart = $request->session()->get('shopping_cart', []);

            if (isset($shoppingCart[$gameId])) {
                if ($shoppingCart[$gameId]['quantity'] >= 10) {
                    $shoppingCart[$gameId]['quantity'] = 10;
                    return response()->json([
                        'success' => false,
                        'quantity_limit' => true,
                        'message' => 'You can only buy up to 10 copies of a game.'
                    ]);
                }
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

            return response()->json([
                'success' => true,
                'new_quantity' => $shoppingCart[$gameId]['quantity'],
                'quantity_limit' => false,
                'new_total' => array_reduce($shoppingCart, function ($carry, $item) {
                    return $carry + ($item['price'] * $item['quantity']);
                }, 0),
            ]);

        } else {
            $buyerId = auth_user()->id;
            $gameId = $request->input('game_id');

            $shoppingCartItem = ShoppingCart::where('buyer', $buyerId)
                                            ->where('game', $gameId)
                                            ->first();

            if (!$shoppingCartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in the shopping cart.'
                ]);
            }
    
            if ($shoppingCartItem->quantity >= 10) {
                return response()->json([
                    'success' => false,
                    'quantity_limit' => true,
                    'message' => 'You can only buy up to 10 copies of a game.'
                ]);
            }
    
            $shoppingCartItem->quantity += 1;
            $shoppingCartItem->save();

            $shoppingCart = ShoppingCart::where('buyer', $buyerId)->get();
            $newTotal = 0;
            foreach ($shoppingCart as $item) {
                $game = Game::find($item->game);
                $newTotal += $game->price * $item->quantity;
            }

            return response()->json([
                'success' => true,
                'new_quantity' => $shoppingCartItem->quantity,
                'quantity_limit' => false,
                'new_total' => $newTotal,
            ]);
        }
    }

    public function decreaseQuantity(Request $request)
    {
        if (!auth_user()) {
            $gameId = $request->input('game_id');
            $shoppingCart = session('shopping_cart', []);

            if (isset($shoppingCart[$gameId])) {
                $shoppingCart[$gameId]['quantity'] -= 1;
                if ($shoppingCart[$gameId]['quantity'] <= 0) {
                    unset($shoppingCart[$gameId]);
                }
            }

            $request->session()->put('shopping_cart', $shoppingCart);

            $newTotal = array_reduce($shoppingCart, function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            return response()->json([
                'success' => true,
                'new_quantity' => $shoppingCart[$gameId]['quantity'] ?? 0,
                'new_total' => $newTotal,
            ]);
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

            $shoppingCart = ShoppingCart::where('buyer', $buyerId)->get();
            $newTotal = 0;
            foreach ($shoppingCart as $item) {
                $game = Game::find($item->game);
                $newTotal += $game->price * $item->quantity;
            }

            return response()->json([
                'success' => true,
                'new_quantity' => $shoppingCartItem->quantity ?? 0,
                'new_total' => $newTotal,
            ]);
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

            return response()->json([
                'success' => true,
                'new_total' => array_reduce($shoppingCart, function ($carry, $item) {
                    return $carry + ($item['price'] * $item['quantity']);
                }, 0),
            ]);

        } else {
            $buyerId = auth_user()->id;
            $gameId = $request->input('game_id');

            $shoppingCartItem = ShoppingCart::where('buyer', $buyerId)
                                            ->where('game', $gameId)
                                            ->first();

            if ($shoppingCartItem) {
                $shoppingCartItem->delete();
            }

            $shoppingCart = ShoppingCart::where('buyer', $buyerId)->get();
            $newTotal = 0;
            foreach ($shoppingCart as $item) {
                $game = Game::find($item->game);
                $newTotal += $game->price * $item->quantity;
            }

            return response()->json([
                'success' => true,
                'new_total' => $newTotal,
            ]);
        }
    }

    public function mergeShoppingCart(Request $request, $shoppingCart)
    {
        $buyerId = auth_user()->id;
        
        foreach ($shoppingCart as $product) {
            $this->addProduct($request, $product['id'], $product['quantity']);
        }
    }

    public function getCartCount(Request $request)
    {
        if (!auth_user()){
            $shoppingCart = $request->session()->get('shopping_cart', []);
            $count = array_reduce($shoppingCart, function ($carry, $item) {
                return $carry + $item['quantity'];
            }, 0);
            return response()->json([
                'count' => $count,
            ]);
        }
        if (auth_user()->buyer) {
            $buyerId = auth_user()->id;
            $count = ShoppingCart::where('buyer', $buyerId)->sum('quantity');
        } else {
            $count = 0;
        }

        return response()->json([
            'count' => $count,
        ]);
    }
}