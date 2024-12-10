<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Game;
use App\Models\Administrator;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Block the specified game.
     */
    public function block(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'reason' => 'required|string|max:200',
        ]);

        $game = Game::findOrFail($id);

        $this->authorize('block', $game);

        $game->is_active = false;
        $game->block_reason = $request->input('reason');
        $game->block_time = Carbon::now();
        $game->save();

        return redirect()->back()->withSuccess('Game blocked successfully.');
    }

    /**
     * Unblock the specified game.
     */
    public function unblock($id): RedirectResponse
    {
        $game = Game::findOrFail($id);

        $this->authorize('unblock', $game);

        $game->is_active = true;
        $game->block_reason = null;
        $game->block_time = null;
        $game->save();

        return redirect()->back()->withSuccess('Game unblocked successfully.');
    }

    /**
     * List all blocked games.
     */
    public function listBlockedGames(): View
    {
        $blockedGames = Game::where('is_active', false)
                            ->orderBy('block_time', 'desc')
                            ->paginate(10);

        return view('admin.games.blocked-games', compact('blockedGames'));
    }
}