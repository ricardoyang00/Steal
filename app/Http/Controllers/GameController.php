<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Category;
use App\Models\Platform;
use App\Models\Language;
use App\Models\Player;

use Illuminate\Http\Request;

class GameController extends Controller
{    
    public function explore(Request $request)
    {
        $query = $request->input('query');
        $sort = $request->input('sort');
        $categories = $request->input('categories', []);
        $platforms = $request->input('platforms', []);
        $languages = $request->input('languages', []);
        $players = $request->input('players', []);

        $gamesQuery = Game::query()->where('is_active', true);

        if ($query) {
            $query = trim(preg_replace('/\s+/', ' ', $query));

            if (!empty($query)) {
                $formattedQuery = implode(' | ', array_map(fn($term) => "{$term}:*", explode(' ', $query)));
                $gamesQuery->whereRaw("tsvectors @@ to_tsquery('english', ?)", [$formattedQuery]);
            }
        }

        if ($sort == 'new-releases') {
            $gamesQuery->orderBy('release_date', 'desc');
        } elseif ($sort == 'top-sellers') {
            $gamesQuery->withCount('deliveredPurchases')->orderBy('delivered_purchases_count', 'desc');
        } elseif ($sort == 'top-rated') {
            $gamesQuery->orderBy('overall_rating', 'desc');
        } else { 
            $gamesQuery->orderBy('name', 'asc');    // default : all games sorted alphabetically
        }

        if (!empty($categories)) {
            $gamesQuery->whereHas('categories', fn($query) => $query->whereIn('category', $categories));
        }

        if (!empty($platforms)) {
            $gamesQuery->whereHas('platforms', fn($query) => $query->whereIn('platform', $platforms));
        }

        if (!empty($languages)) {
            $gamesQuery->whereHas('languages', fn($query) => $query->whereIn('language', $languages));
        }

        if (!empty($players)) {
            $gamesQuery->whereHas('players', fn($query) => $query->whereIn('player', $players));
        }
        
        $games = $gamesQuery->with('platforms')->paginate(6);

        // Check if the requested page number exceeds the total number of pages
        $currentPage = $request->input('page', 1);
        $lastPage = $games->lastPage();

        if ($currentPage > $lastPage) {
            return redirect()->route('explore', ['sort' => $sort, 'page' => $lastPage, 'query' => $query]);
        }

        $categories = Category::orderBy('name', 'asc')->get();
        $platforms = Platform::orderBy('name', 'asc')->get();
        $languages = Language::orderBy('name', 'asc')->get();
        $players = Player::orderBy('name', 'asc')->get();

        return view('pages.explore', compact('games', 'query', 'sort', 'categories', 'platforms', 'languages', 'players'));
    }

    public function show($id)
    {
        $game = Game::with(['seller', 'platforms', 'categories', 'languages', 'players'])->find($id);
    
        return view('pages.game-details', compact('game'));
    }
}
