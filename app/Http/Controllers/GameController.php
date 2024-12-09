<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Category;
use App\Models\Platform;
use App\Models\Language;
use App\Models\Player;
use App\Models\Age;
use App\Models\GameMedia;
use App\Models\Review;
use App\Models\CDK;
use App\Http\Controllers\NotificationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{    
    public function __construct(NotificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }

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
        $game = Game::with(['seller', 'platforms', 'categories', 'languages', 'players'])
                ->findOrFail($id);

        $user = auth_user();
        $userId = $user ? $user->id : -1;
        
        if (!$user || $user->buyer || ($user->seller && $game->seller->id != $userId)) {
            if (!$game->is_active) {
                abort(403, 'This game has been blocked');
            }
        }

        $review = Review::where('game', $game->id)->where('author', $userId)->first();

        if (!$review) {
            $review = new Review();
            $review->id = null;
            $review->game = $game->id;
            $review->author = $userId;
            $review->positive = true;
            $review->title = '';
            $review->description = '';
        }

        return view('pages.game-details', compact('game', 'review'));
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
                    ->orderBy('name', 'asc')
                    ->paginate(10);

        return view('seller.products', compact('games'));
    }

    public function edit($id) {
        $game = Game::with(['categories', 'platforms', 'languages', 'players', 'images'])->findOrFail($id);
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

        $oldPrice = $game->price;

        // Update game attributes
        $game->update($request->except(['thumbnail_large_path', 'thumbnail_small_path', 'additional_images']));

        // Update relationships
        $game->categories()->sync($request->input('categories', []));
        $game->platforms()->sync($request->input('platforms', []));
        $game->languages()->sync($request->input('languages', []));
        $game->players()->sync($request->input('players', []));

        // Handle thumbnail large image
        if ($request->hasFile('thumbnail_large_path')) {
            $thumbnailLargePath = 'images/gamemedia/' . uniqid() . '.' . $request->file('thumbnail_large_path')->getClientOriginalExtension();
            $request->file('thumbnail_large_path')->move(public_path('images/gamemedia'), $thumbnailLargePath);
            $game->thumbnail_large_path = $thumbnailLargePath;
        }

        // Handle thumbnail small image
        if ($request->hasFile('thumbnail_small_path')) {
            $thumbnailSmallPath = 'images/gamemedia/' . uniqid() . '.' . $request->file('thumbnail_small_path')->getClientOriginalExtension();
            $request->file('thumbnail_small_path')->move(public_path('images/gamemedia'), $thumbnailSmallPath);
            $game->thumbnail_small_path = $thumbnailSmallPath;
        }

        // Handle additional images
        if ($request->hasFile('additional_images')) {
            // Delete existing images
            foreach ($game->images as $media) {
                if (File::exists(public_path($media->path))) {
                    File::delete(public_path($media->path));
                }
                $media->delete();
            }

            // Upload new images
            foreach ($request->file('additional_images') as $image) {
                $imagePath = 'images/gamemedia/' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/gamemedia'), $imagePath);
                GameMedia::create([
                    'path' => $imagePath,
                    'game' => $game->id
                ]);
                Log::info('Additional image uploaded', ['path' => $imagePath]);
            }
        }

        $game->save();

        if ($oldPrice != $game->price) {
            $this->notificationController->createPriceNotifications($game, $oldPrice, $game->price);
        }

        return redirect()->route('seller.products')->withSuccess('Game updated successfully.');
    }

    public function create()
    {
        $categories = Category::all();
        $platforms = Platform::all();
        $languages = Language::all();
        $players = Player::all();
        $ages = Age::all();

        return view('seller.game-new', compact('categories', 'platforms', 'languages', 'players', 'ages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:9999.99',
            'release_date' => 'nullable|date',
            'age_id' => 'required|exists:age,id',
            'categories' => 'array',
            'platforms' => 'array',
            'languages' => 'array',
            'players' => 'array',
            'thumbnail_small_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'thumbnail_large_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $game = new Game();
            $game->name = $request->name;
            $game->description = $request->description;
            $game->price = $request->price;
            $game->release_date = $request->pre_release ? null : $request->release_date;
            $game->age_id = $request->age_id;
            $game->owner = auth()->user()->id;
            $game->is_active = true;

            // Handle small thumbnail upload
            if ($request->hasFile('thumbnail_small_path')) {
                // Delete the old small thumbnail if it exists
                if ($game->thumbnail_small_path && File::exists(public_path($game->thumbnail_small_path))) {
                    File::delete(public_path($game->thumbnail_small_path));
                }

                // Store the new small thumbnail
                $file = $request->file('thumbnail_small_path');
                $smallPath = 'images/thumbnail_small/' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/thumbnail_small'), $smallPath);
                $game->thumbnail_small_path = $smallPath;
                Log::info('Small thumbnail uploaded', ['path' => $smallPath]);
            }
            // Handle large thumbnail upload
            if ($request->hasFile('thumbnail_large_path')) {
                // Delete the old large thumbnail if it exists
                if ($game->thumbnail_large_path && File::exists(public_path($game->thumbnail_large_path))) {
                    File::delete(public_path($game->thumbnail_large_path));
                }

                // Store the new large thumbnail
                $file = $request->file('thumbnail_large_path');
                $largePath = 'images/thumbnail_large/' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/thumbnail_large'), $largePath);
                $game->thumbnail_large_path = $largePath;
                Log::info('Large thumbnail uploaded', ['path' => $largePath]);
            }

            $game->save();
            Log::info('Game created successfully', ['game_id' => $game->id]);

            $game->categories()->sync($request->categories);
            Log::info('Categories synced', ['categories' => $request->categories]);

            $game->platforms()->sync($request->platforms);
            Log::info('Platforms synced', ['platforms' => $request->platforms]);

            $game->languages()->sync($request->languages);
            Log::info('Languages synced', ['languages' => $request->languages]);

            $game->players()->sync($request->players);
            Log::info('Players synced', ['players' => $request->players]);
            
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $image) {
                    $imagePath = 'images/gamemedia/' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images/gamemedia'), $imagePath);
                    GameMedia::create([
                        'path' => $imagePath,
                        'game' => $game->id
                    ]);
                    Log::info('Additional image uploaded', ['path' => $imagePath]);
                }
            }

            return redirect()->route('seller.products')->withSuccess('Game created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating game', ['error' => $e->getMessage()]);
            return redirect()->route('seller.products')->withErrors('Failed to create game.');
        }
    }

    public function showCdks(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $filter = $request->input('filter', 'all');

        $query = CDK::where('game', $id);

        if ($filter === 'available') {
            $query->whereDoesntHave('deliveredPurchase');
        } elseif ($filter === 'sold') {
            $query->whereHas('deliveredPurchase');
        }

        $cdks = $query->orderBy('id', 'desc')->paginate(25);

        return view('seller.game-cdks', compact('game', 'cdks', 'filter'));
    }

    public function addCdks(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $game = Game::findOrFail($id);

        for ($i = 0; $i < $request->quantity; $i++) {
            $cdk = new CDK();
            $cdk->code = $this->generateUniqueCode(26);
            $cdk->game = $game->id;
            $cdk->save();
        }

        return redirect()->route('games.cdks', $game->id)->with('success', 'CDKs added successfully.');
    }

    private function generateUniqueCode($length = 26)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        do {
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $randomString = strtoupper($randomString);
        } while (CDK::where('code', $randomString)->exists());

        return $randomString;
    }

    public function purchaseHistory($id)
    {
        $game = Game::findOrFail($id);
        $purchases = DB::table('deliveredpurchase')
            ->join('cdk', 'deliveredpurchase.cdk', '=', 'cdk.id')
            ->join('purchase', 'deliveredpurchase.id', '=', 'purchase.id')
            ->join('orders', 'purchase.order_', '=', 'orders.id')
            ->join('users', 'orders.buyer', '=', 'users.id')
            ->where('cdk.game', $id)
            ->select('deliveredpurchase.*', 'cdk.code as cdk_code', 'purchase.value', 'orders.time', 'users.name as buyer_name')
            ->orderBy('orders.time', 'desc')
            ->paginate(25);

        return view('seller.game-history', compact('game', 'purchases'));
    }

    public function deleteMedia($id)
    {
        $media = GameMedia::findOrFail($id);

        // Delete the media file from the storage
        if (File::exists(public_path($media->path))) {
            File::delete(public_path($media->path));
        }

        // Delete the media record from the database
        $media->delete();

        return redirect()->back()->withSuccess('Media deleted successfully.');
    }
}
