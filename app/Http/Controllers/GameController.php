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
            // Trim and normalize the query
            $query = trim(preg_replace('/\s+/', ' ', $query));

            // Ensure the query is not empty after normalization
            if (!empty($query)) {
                $formattedQuery = implode(' | ', array_map(fn($term) => "{$term}:*", explode(' ', $query)));
                $gamesQuery->whereRaw("tsvectors @@ to_tsquery('english', ?)", [$formattedQuery]);
            }
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
        
        $games = $gamesQuery->with('platforms')->paginate(6);

        return view('pages.explore', compact('games', 'query', 'sort'));
    }

    public function show($id)
    {
        $game = Game::with(['seller', 'platforms', 'categories', 'languages', 'players'])->find($id);
    
        return view('pages.game-details', compact('game'));
    }
}
