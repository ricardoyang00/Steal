<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\Category;
use App\Models\Platform;
use App\Models\Language;

class GameFieldsController extends Controller
{
    public function create()
    {
        return view('admin.games.create-game-field');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:category,platform,language',
            'name' => 'required|string|max:255',
        ]);

        switch ($request->type) {
            case 'category':
                Category::create(['name' => $request->name]);
                break;
            case 'platform':
                Platform::create(['name' => $request->name]);
                break;
            case 'language':
                Language::create(['name' => $request->name]);
                break;
        }

        return redirect()->route('admin.createGameField')->withSuccess(ucfirst($request->type) . ' created successfully.');
    }
}
