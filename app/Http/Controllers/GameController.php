<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Category;
use App\Models\Platform;
use App\Models\Language;
use App\Models\Player;
use App\Models\Age;

use Illuminate\Http\Request;

class GameController extends Controller
{    
    public function home()
    {
        [$topSellersChunks, $similarGames] = $this->getTopSellersAndSimilarGames();

        return view('pages.home', compact('topSellersChunks', 'similarGames'));
    }

    public function loadChunk($chunkIndex)
    {
        [$topSellersChunks, $similarGames] = $this->getTopSellersAndSimilarGames();

        return view('partials.home.top-sellers-chunk', [
            'topSellersChunk' => $topSellersChunks[$chunkIndex],
            'chunkIndex' => $chunkIndex,
            'similarGames' => $similarGames
        ]);
    }

    private function getTopSellersAndSimilarGames()
    {
        $topSellers = Game::query()
            ->where('is_active', true)
            ->withCount('deliveredPurchases')
            ->orderBy('delivered_purchases_count', 'desc')
            ->take(15)
            ->get();
    
        // Split top sellers into three lists of 5 games each
        $topSellersChunks = $topSellers->chunk(5);
    
        $similarGames = collect();
        $totalSimilarGames = 0;
        $maxSimilarGames = 16;
    
        foreach ($topSellersChunks as $chunkIndex => $topSellersChunk) {
            foreach ($topSellersChunk as $topSeller) {
                if ($totalSimilarGames >= $maxSimilarGames) {
                    break 2; // Exit both loops if we have collected 16 similar games
                }
            
                $games = Game::query()
                    ->where('is_active', true)
                    ->whereHas('categories', function ($query) use ($topSeller) {
                        $query->whereIn('category.id', $topSeller->categories->pluck('id'));
                    })
                    ->whereNotIn('id', $topSellers->pluck('id'))
                    ->take(4)
                    ->get();
                
                // If there are less than 4 similar games, add top-rated games with the same categories
                if ($games->count() < 4) {
                    $additionalGames = Game::query()
                        ->where('is_active', true)
                        ->whereHas('players', function ($query) use ($topSeller) {
                            $query->whereIn('player.id', $topSeller->players->pluck('id'));
                        })
                        ->whereNotIn('id', $topSellers->pluck('id'))
                        ->whereNotIn('id', $games->pluck('id'))
                        ->orderBy('overall_rating', 'desc')
                        ->take(4 - $games->count())
                        ->get();
                    
                    $games = $games->merge($additionalGames);
                }
            
                // Add only the required number of games to reach the limit
                $remainingSlots = $maxSimilarGames - $totalSimilarGames;
                $gamesToAdd = $games->take($remainingSlots);
                $similarGames = $similarGames->merge($gamesToAdd);
                $totalSimilarGames += $gamesToAdd->count();
            }
        }
    
        return [$topSellersChunks, $similarGames];
    }

    public function explore(Request $request)
    {
        $query = $request->input('query');
        $sort = $request->input('sort');
        $categories = $request->input('categories', []);
        $platforms = $request->input('platforms', []);
        $languages = $request->input('languages', []);
        $players = $request->input('players', []);
    
        $gamesQuery = Game::query()->where('is_active', true);
    
        $this->applySearchQuery($gamesQuery, $query);
        $this->applyFilters($gamesQuery, $categories, $platforms, $languages, $players);
        $this->applySorting($gamesQuery, $sort);
    
        $games = $gamesQuery->with('platforms')->paginate(6);
    
        $currentPage = $request->input('page', 1);
        $lastPage = $games->lastPage();
    
        if ($currentPage > $lastPage) {
            return redirect()->route('explore', ['sort' => $sort, 'page' => $lastPage, 'query' => $query]);
        }
    
        $categories = Category::orderBy('name', 'asc')->get();
        $platforms = Platform::orderBy('name', 'asc')->get();
        $languages = Language::orderBy('name', 'asc')->get();
        $players = Player::orderBy('name', 'asc')->get();

        if ($request->ajax()) {
            return view('partials.explore.game-cards', compact('games'))->render();
        }
    
        return view('pages.explore', compact('games', 'query', 'sort', 'categories', 'platforms', 'languages', 'players'));
    }    

    public function show($id)
    {
        $game = Game::with(['seller', 'platforms', 'categories', 'languages', 'players'])->find($id);
    
        return view('pages.game-details', compact('game'));
    }

    protected function applySearchQuery($gamesQuery, $query)
    {
        if ($query) {
            $query = trim(preg_replace('/\s+/', ' ', $query));

            if (!empty($query)) {
                $formattedQuery = implode(' | ', array_map(fn($term) => "{$term}:*", explode(' ', $query)));
                $gamesQuery->whereRaw("tsvectors @@ to_tsquery('english', ?)", [$formattedQuery]);
            }
        }
    }

    protected function applyFilters($gamesQuery, $categories, $platforms, $languages, $players)
    {
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
    }

    protected function applySorting($gamesQuery, $sort)
    {
        if ($sort == 'new-releases') {
            $gamesQuery->orderBy('release_date', 'desc');
        } elseif ($sort == 'top-sellers') {
            $gamesQuery->withCount('deliveredPurchases')->orderBy('delivered_purchases_count', 'desc');
        } elseif ($sort == 'top-rated') {
            $gamesQuery->orderBy('overall_rating', 'desc');
        } else { 
            $gamesQuery->orderBy('name', 'asc'); // Default sorting by name
        }
    }
    

    public function listProducts(Request $request) {
        if (!auth_user() || !auth_user()->seller) {
            return redirect()->route('login');
        }

        $sellerId = auth()->user()->id;
        $games = Game::where('owner', $sellerId)
                    ->with(['platforms', 'categories', 'languages', 'players'])
                    ->paginate(10);

        return view('seller.products', compact('games'));
    }

    public function edit($id) {
        $game = Game::with(['categories', 'platforms', 'languages', 'players'])->findOrFail($id);
        $categories = Category::all();
        $platforms = Platform::all();
        $languages = Language::all();
        $players = Player::all();
        $ages = Age::all();

        return view('seller.game-edit', compact('game', 'categories', 'platforms', 'languages', 'players', 'ages'));
    }

    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $game->update($request->all());

        // Update relationships
        $game->categories()->sync($request->input('categories', []));
        $game->platforms()->sync($request->input('platforms', []));
        $game->languages()->sync($request->input('languages', []));
        $game->players()->sync($request->input('players', []));

        return redirect()->route('games.edit', $game->id)->with('success', 'Game updated successfully.');
    }
}
