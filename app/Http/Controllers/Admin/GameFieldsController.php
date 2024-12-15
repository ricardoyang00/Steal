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
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $platforms = Platform::orderBy('name', 'asc')->get();
        $languages = Language::orderBy('name', 'asc')->get();

        return view('admin.games.index-game-field', compact('categories', 'platforms', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:category,platform,language',
            'name' => ['required', 'string', 'max:20', 'regex:/^[A-Za-z\s]+$/'],
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

        return redirect()->route('admin.indexGameField')->withSuccess(ucfirst($request->type) . ' created successfully.');
    }

    public function edit($type, $id)
    {
        switch ($type) {
            case 'category':
                $entry = Category::findOrFail($id);
                break;
            case 'platform':
                $entry = Platform::findOrFail($id);
                break;
            case 'language':
                $entry = Language::findOrFail($id);
                break;
        }

        return view('admin.games.edit-game-field', compact('entry', 'type'));
    }

    public function update(Request $request, $type, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20', 'regex:/^[A-Za-z\s]+$/'],
        ]);

        switch ($type) {
            case 'category':
                $entry = Category::findOrFail($id);
                break;
            case 'platform':
                $entry = Platform::findOrFail($id);
                break;
            case 'language':
                $entry = Language::findOrFail($id);
                break;
        }

        $oldName = $entry->name;
        $entry->update(['name' => $request->name]);

        return redirect()->route('admin.indexGameField')->withSuccess(ucfirst($type) . ' "' . $oldName . '" changed to "' . $request->name . '" successfully.');
    }

    public function destroy($type, $id)
    {
        switch ($type) {
            case 'category':
                $entry = Category::findOrFail($id);
                $name = $entry->name;
                \DB::table('gamecategory')->where('category', $id)->delete();
                $entry->delete();
                break;
            case 'platform':
                $entry = Platform::findOrFail($id);
                $name = $entry->name;
                \DB::table('gameplatform')->where('platform', $id)->delete();
                $entry->delete();
                break;
            case 'language':
                $entry = Language::findOrFail($id);
                $name = $entry->name;
                \DB::table('gamelanguage')->where('language', $id)->delete();
                $entry->delete();
                break;
        }

        return redirect()->route('admin.indexGameField')->withSuccess(ucfirst($type) . ' "' . $name . '" deleted successfully.');
    }
}
