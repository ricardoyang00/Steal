<?php

namespace App\Http\Controllers;

use App\Models\Game;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter');
        
        $gamesQuery = Game::where('is_active', true);
        
        if ($filter == 'new-releases') {
            $gamesQuery->orderBy('release_date', 'desc');
        } /*elseif ($filter == 'top-selling') { // TODO
            $gamesQuery->withCount('purchases')
               ->orderBy('purchases_count', 'desc');
        }*/ elseif ($filter == 'top-rated') {
            $gamesQuery->orderBy('overall_rating', 'desc');
        } else { // default : all games sorted alphabetically
            $gamesQuery->orderBy('name', 'asc');
        }
        
        $games = $gamesQuery->paginate(6);

        return view('pages.explore', compact('games'));
    }   

    public function show($id)
    {
        $game = Game::with('seller')->findOrFail($id);
        return view('pages.game-details', compact('game'));
    }
}
