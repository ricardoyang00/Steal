<?php

namespace App\Http\Controllers;

use App\Models\Game;

use Illuminate\Http\Request;

class GameController extends Controller
{    
    public function home()
    {
        $topSellers = Game::query()
            ->where('is_active', true)
            ->withCount('deliveredPurchases')
            ->orderBy('delivered_purchases_count', 'desc')
            ->take(15)
            ->get();
        
        $similarGames = [];

        foreach ($topSellers as $topSeller) {
            $similarGames[$topSeller->id] = Game::query()
                ->where('is_active', true)
                ->whereHas('categories', function ($query) use ($topSeller) {
                    $query->whereIn('category.id', $topSeller->categories->pluck('id'));
                })
                ->whereNotIn('id', $topSellers->pluck('id'))
                ->take(4)
                ->get();

            // If there are less than 4 similar games, add top-rated games with the same categories
            if ($similarGames[$topSeller->id]->count() < 4) {
                $additionalGames = Game::query()
                    ->where('is_active', true)
                    ->whereHas('players', function ($query) use ($topSeller) {
                        $query->whereIn('player.id', $topSeller->players->pluck('id'));
                    })
                    ->whereNotIn('id', $topSellers->pluck('id'))
                    ->whereNotIn('id', $similarGames[$topSeller->id]->pluck('id'))
                    ->orderBy('overall_rating', 'desc')
                    ->take(4 - $similarGames[$topSeller->id]->count())
                    ->get();
                
                $similarGames[$topSeller->id] = $similarGames[$topSeller->id]->merge($additionalGames);
            }
        }

        return view('pages.home', compact('topSellers', 'similarGames'));
    }

    public function explore(Request $request)
    {
        $query = $request->input('query');
        $sort = $request->input('sort');

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
        
        $games = $gamesQuery->with('platforms')->paginate(6);

        // Check if the requested page number exceeds the total number of pages
        $currentPage = $request->input('page', 1);
        $lastPage = $games->lastPage();

        if ($currentPage > $lastPage) {
            return redirect()->route('explore', ['sort' => $sort, 'page' => $lastPage, 'query' => $query]);
        }

        return view('pages.explore', compact('games', 'query', 'sort'));
    }

    public function show($id)
    {
        $game = Game::with(['seller', 'platforms', 'categories', 'languages', 'players'])->find($id);
    
        return view('pages.game-details', compact('game'));
    }
}
