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
use App\Models\Reason;
use App\Models\CDK;
use App\Http\Controllers\NotificationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redirect;

class GameController extends Controller
{    
    public function __construct(NotificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }

    /* Home Page */
    public function home()
    {
        [$topSellersChunks, $similarGames] = $this->getTopSellersAndSimilarGames();
        $recommendedGames = $this->getRecommendedGamesForUser();

        return view('pages.home', compact('topSellersChunks', 'similarGames', 'recommendedGames'));
    }

    private function getRecommendedGamesForUser()
    {
        $user = auth()->user();

        if (!$user || !$user->buyer) {
            return collect(); // Return an empty collection if the user is not a buyer
        }

        // Get the last order of the user
        $lastOrder = DB::table('orders')
            ->where('buyer', $user->id)
            ->orderBy('time', 'desc')
            ->first();

        if (!$lastOrder) {
            return collect(); // Return an empty collection if the user has no orders
        }

        // Get the categories of the games in the last order
        $categories = DB::table('deliveredpurchase')
            ->join('cdk', 'deliveredpurchase.cdk', '=', 'cdk.id')
            ->join('game', 'cdk.game', '=', 'game.id')
            ->join('gamecategory', 'game.id', '=', 'gamecategory.game')
            ->where('deliveredpurchase.id', $lastOrder->id)
            ->pluck('gamecategory.category')
            ->unique();
        
        // Get the IDs of the games the user has purchased
        $purchasedGameIds = DB::table('deliveredpurchase')
            ->join('cdk', 'deliveredpurchase.cdk', '=', 'cdk.id')
            ->join('purchase', 'deliveredpurchase.id', '=', 'purchase.id')
            ->join('orders', 'purchase.order_', '=', 'orders.id')
            ->where('orders.buyer', $user->id)
            ->pluck('cdk.game');

        // Get 6 games in the same categories that the user has not purchased
        $recommendedGames = Game::query()
            ->where('is_active', true)
            ->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('category.id', $categories);
            })
            ->whereNotIn('id', $purchasedGameIds)
            ->take(6)
            ->get();

        return $recommendedGames;
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
    
        $addedGameIds = collect(); // Initialize a collection to keep track of added game IDs

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
                    ->whereNotIn('id', $addedGameIds) // Ensure games are not repeated
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
                        ->whereNotIn('id', $addedGameIds) // Ensure games are not repeated
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
                
                // Add the IDs of the added games to the set
                $addedGameIds = $addedGameIds->merge($gamesToAdd->pluck('id'));
            }
        }
    
        return [$topSellersChunks, $similarGames];
    }

    /* Explore Page */
    public function explore(Request $request)
    {
        $query = $request->input('query');
        $sort = $request->input('sort');
        $categories = $request->input('categories', []);
        $platforms = $request->input('platforms', []);
        $languages = $request->input('languages', []);
        $players = $request->input('players', []);
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
    
        $gamesQuery = Game::query()->where('is_active', true);
    
        $this->applySearchQuery($gamesQuery, $query);
        $this->applyFilters($gamesQuery, $categories, $platforms, $languages, $players);
        
        // Apply price range filter
        if ($minPrice !== null) {
            $gamesQuery->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $gamesQuery->where('price', '<=', $maxPrice);
        }

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
    
        return view('pages.explore', compact('games', 'query', 'sort', 'categories', 'platforms', 'languages', 'players', 'minPrice', 'maxPrice'));
    }    

    /* Game-Details Page*/
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

        // Fetch the logged-in user's review if it exists
        $userReview = Review::where('game', $game->id)->where('author', $userId)->first();

        // Fetch reviews and handle pagination
        $reviews = $this->fetchReviews($game->id, $userId, $userReview);

        // Fetch the reasons for report
        $reportReasons = Reason::all();

        return view('pages.game-details', compact('game', 'reviews', 'userReview', 'reportReasons'));
    }

    private function fetchReviews($gameId, $userId, $userReview)
    {
        // Fetch all other reviews excluding the logged-in user's review, ordered by ID in descending order
        $otherReviewsQuery = Review::where('game', $gameId)
                                    ->where('author', '!=', $userId)
                                    ->withCount('likes')
                                    ->orderBy('likes_count', 'desc');

        // Determine the total reviews and calculate total pages
        $totalReviews = $otherReviewsQuery->count() + ($userReview ? 1 : 0);
        $perPage = 5;
        $lastPage = ceil($totalReviews / $perPage);

        // Determine the current page from the URL, defaulting to 1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        if ($currentPage > $lastPage && $lastPage > 0) {
            // Redirect to the last page if the requested page exceeds it
            return Redirect::to(request()->url() . '?page=' . $lastPage);
        }

        // Initialize reviews collection
        $reviewsCollection = collect();

        if ($currentPage == 1 && $userReview) {
            // On the first page, include the user's review and fetch only 4 additional reviews
            $otherReviews = $otherReviewsQuery->limit($perPage - 1)->get();
            $reviewsCollection = collect([$userReview])->merge($otherReviews);
        } else {
            // On other pages, fetch the correct 5 reviews using offset
            $offset = $userReview ? (($currentPage - 2) * $perPage + ($perPage - 1)) : (($currentPage - 1) * $perPage);
            $otherReviews = $otherReviewsQuery->skip($offset)->take($perPage)->get();
            $reviewsCollection = $otherReviews;
        }

        // Create the paginator
        return new LengthAwarePaginator(
            $reviewsCollection,
            $totalReviews,
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }

    /* Explore Page Filters */
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
    
    // Seller function, where the seller can see the list of their products
    public function listProducts(Request $request) {
        if (!auth_user() || !auth_user()->seller) {
            return redirect()->route('login');
        }
    
        $sellerId = auth()->user()->id;
        $games = Game::where('owner', $sellerId)
                    ->with(['platforms', 'categories', 'languages', 'players'])
                    ->orderBy('name', 'asc')
                    ->paginate(10);
        
        $games->getCollection()->transform(function ($game) {
            $game->stock = $game->stock;
            return $game;
        });   
    
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
            }

            $game->save();

            $game->categories()->sync($request->categories);

            $game->platforms()->sync($request->platforms);

            $game->languages()->sync($request->languages);

            $game->players()->sync($request->players);
            
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $image) {
                    $imagePath = 'images/gamemedia/' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images/gamemedia'), $imagePath);
                    GameMedia::create([
                        'path' => $imagePath,
                        'game' => $game->id
                    ]);
                }
            }

            return redirect()->route('seller.products')->withSuccess('Game created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('seller.products')->withErrors('Failed to create game.');
        }
    }

    public function showCdks(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $filter = $request->input('filter', 'all');
        
        $totalAvailable = $game->stock;
        $totalSold = $game->sold;

        $query = CDK::where('game', $id);

        if ($filter === 'available') {
            $query->whereDoesntHave('deliveredPurchase');
        } elseif ($filter === 'sold') {
            $query->whereHas('deliveredPurchase');
        }

        $cdks = $query->orderBy('id', 'desc')->paginate(25);

        return view('seller.game-cdks', compact('game', 'cdks', 'filter', 'totalAvailable', 'totalSold'));
    }

    public function addCdks(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $game = Game::findOrFail($id);
        $previousStock = $game->getStockAttribute();

        if ($game->block_reason !== null && $game->block_time !== null) {
            return redirect()->route('games.cdks', $game->id)->withErrors('You cannot add CDKs for a blocked game');
        }

        $quantity = $request->quantity;
        $this->notificationController->createOrderStatusChangeNotification($game, $quantity);

        $initialReleaseDate = $game->release_date;

        for ($i = 0; $i < $request->quantity; $i++) {
            $cdk = new CDK();
            $cdk->code = $this->generateUniqueCode(26);
            $cdk->game = $game->id;
            $cdk->save();
        }

        $game->refresh();

        if($previousStock === 0){
            $this->notificationController->createStockNotifications($game, 'available');
        }

        $message = 'CDKs added successfully.';
        if ($initialReleaseDate === null && $game->release_date !== null) {
            $message .= ' The game has been released.';
        }

        return redirect()->route('games.cdks', $game->id)->with('success', $message);
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
}
