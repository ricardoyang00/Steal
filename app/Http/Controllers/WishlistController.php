<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use App\Models\User;

class WishlistController extends Controller
{
    public function index() {
        if (auth_user() && auth_user()->buyer) {
            return view('pages/wishlist', 
                ['products' => $this->getProducts()]
            );
        } else {
            return redirect()->route('login');
        }
    }

    private function getProducts() {
        $products = [];
        $total = 0;

        if (Auth::user()) {
            $wishlistItems = Wishlist::where('buyer', Auth::user()->id)->get();
            foreach ($wishlistItems as $item) {
                $game = Game::find($item->game);
                if ($game) {
                    $products[] = [
                        'id' => $game->id,
                        'name' => $game->name,
                        'price' => $game->price
                    ];
                }
                $total += $game->price;
            }
        }

        ksort($products);

        return $products;
    }

    public function addProduct(Request $request) {
        // $gameId = $request->input('game_id');
        // $buyerId = Auth::user()->id;

        // $wishlistItem = Wishlist::where('buyer', $buyerId)
        //     ->where('game', $gameId)
        //     ->first();

        // if (!$wishlistItem) {
        //     $wishlistItem = new Wishlist();
        //     $wishlistItem->buyer = $buyerId;
        //     $wishlistItem->game = $gameId;
        //     $wishlistItem->save();
        // }

        return response()->json([
            'success' => true,
        ]);
    }

    public function removeProduct(Request $request) {
        $gameId = $request->input('game_id');
        $buyerId = Auth::user()->id;

        $wishlistItem = Wishlist::where('buyer', $buyerId)
            ->where('game', $gameId)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
