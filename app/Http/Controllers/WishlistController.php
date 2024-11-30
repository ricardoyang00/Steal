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
        return view('pages/wishlist', 
            ['products' => $this->getProducts()]
        );
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
}
