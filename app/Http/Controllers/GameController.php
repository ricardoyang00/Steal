<?php

namespace App\Http\Controllers;

use App\Models\Game;

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

        return view('partials.top-sellers-chunk', [
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

        $similarGames = [];

        foreach ($topSellersChunks as $chunkIndex => $topSellersChunk) {
            foreach ($topSellersChunk as $topSeller) {
                $similarGames[$chunkIndex][$topSeller->id] = Game::query()
                    ->where('is_active', true)
                    ->whereHas('categories', function ($query) use ($topSeller) {
                        $query->whereIn('category.id', $topSeller->categories->pluck('id'));
                    })
                    ->whereNotIn('id', $topSellers->pluck('id'))
                    ->take(4)
                    ->get();

                // If there are less than 4 similar games, add top-rated games with the same categories
                if ($similarGames[$chunkIndex][$topSeller->id]->count() < 4) {
                    $additionalGames = Game::query()
                        ->where('is_active', true)
                        ->whereHas('players', function ($query) use ($topSeller) {
                            $query->whereIn('player.id', $topSeller->players->pluck('id'));
                        })
                        ->whereNotIn('id', $topSellers->pluck('id'))
                        ->whereNotIn('id', $similarGames[$chunkIndex][$topSeller->id]->pluck('id'))
                        ->orderBy('overall_rating', 'desc')
                        ->take(4 - $similarGames[$chunkIndex][$topSeller->id]->count())
                        ->get();

                    $similarGames[$chunkIndex][$topSeller->id] = $similarGames[$chunkIndex][$topSeller->id]->merge($additionalGames);
                }
            }
        }

        return [$topSellersChunks, $similarGames];
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
