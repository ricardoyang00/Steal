<?php

namespace App\Http\Controllers;

use App\Models\Game;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::where('is_active', true)->get();
        return view('pages.home', compact('games'));
    }

    public function show($id)
    {
        $game = Game::with('seller')->findOrFail($id);
        return view('pages.game-details', compact('game'));
    }
}
