<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Wishlist;
use Exception;

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
        $gameId = $request->input('game_id');
        $buyerId = Auth::user()->id;

        $wishlistItem = Wishlist::where('buyer', $buyerId)
            ->where('game', $gameId)
            ->first();

        try {
            if (!$wishlistItem) {
                $wishlistItem = new Wishlist();
                $wishlistItem->buyer = $buyerId;
                $wishlistItem->game = $gameId;
                $wishlistItem->save();
            } else {
                $wishlistItem->delete();
            }

            return response()->json([
                'success' => true,
                'wl' => $wishlistItem
            ]);
        } catch (Exception $e) {
            \Log::error('Error adding product to wishlist: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the product to the wishlist.'
            ]);
        }
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
