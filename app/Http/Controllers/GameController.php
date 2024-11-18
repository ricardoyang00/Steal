<?php

namespace App\Http\Controllers;

use App\Models\Game;

use Illuminate\Http\Request;

class GameController extends Controller
{    
    public function explore(Request $request)
    {
        $query = $request->input('query');
        $sort = $request->input('sort');

        $gamesQuery = Game::query()->where('is_active', true);

        if ($query) {
            $gamesQuery->where(function ($subQuery) use ($query) {
                $subQuery->where('name', 'ILIKE', "%{$query}%")
                        ->orWhere('description', 'ILIKE', "%{$query}%");
            });
        }

        if ($sort == 'new-releases') {
            $gamesQuery->orderBy('release_date', 'desc');
        } /*elseif ($sort == 'top-selling') { // TODO
            $gamesQuery->withCount('purchases')
               ->orderBy('purchases_count', 'desc');
        }*/ elseif ($sort == 'top-rated') {
            $gamesQuery->orderBy('overall_rating', 'desc');
        } else { 
            $gamesQuery->orderBy('name', 'asc');    // default : all games sorted alphabetically
        }
        
        $games = $gamesQuery->paginate(6);

        return view('pages.explore', compact('games', 'query', 'sort'));
    }

    public function show($id)
    {
        $game = Game::with(['seller', 'gamePlatforms', 'gameCategories', 'gameLanguages', 'gamePlayers'])->find($id);
    
        return view('pages.game-details', compact('game'));
    }
}
