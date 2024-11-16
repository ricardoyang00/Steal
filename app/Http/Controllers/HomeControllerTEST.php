<?php

namespace App\Http\Controllers;

use App\Models\Game;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $filter = $request->input('filter', 'top-rated'); // Default filter

        switch ($filter) {
            case 'top-selling':
                $games = $this->getTopSellingGames();
                break;
            case 'new-releases':
                $games = $this->getNewTrendingGames();
                break;
            case 'top-rated':
                $games = $this->getTopRatedGames();
                break;
        }

        return view('pages.home', compact('games'));
    }

    private function getTopSellingGames()
    {
        return Game::join('purchases', 'games.id', '=', 'purchases.game_id')
            ->select('games.*', DB::raw('COUNT(purchases.id) as purchase_count'))
            ->groupBy('games.id')
            ->orderByDesc('purchase_count')
            ->limit(10)
            ->get();
    }

    private function getTopRatedGames()
    {
        return Game::orderByDesc('overall_rating')
            ->limit(10)
            ->get();
    }
}
