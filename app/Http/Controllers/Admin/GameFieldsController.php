<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;
use Illuminate\Support\Facades\File;

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
            'logo' => 'required_if:type,platform|file|mimes:svg|max:2048',
        ]);
        $this->validateName($request);

        switch ($request->type) {
            case 'category':
                Category::create(['name' => $request->name]);
                break;
            case 'platform':
                $platform = Platform::create(['name' => $request->name]);
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $logoPath = 'images/platform_logos/' . $platform->id . '.svg';
                    $file->move(public_path('images/platform_logos'), $platform->id . '.svg');
                }
                break;
            case 'language':
                Language::create(['name' => $request->name]);
                break;
        }

        return redirect()->route('admin.indexGameField')->withSuccess(ucfirst($request->type) . ' created successfully.');
    }

    public function update(Request $request, $type, $id)
    {
        $this->validateName($request, $id);
        $request->validate([
            'logo' => 'nullable|file|mimes:svg|max:2048',
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

        if ($type === 'platform' && $request->hasFile('logo')) {
            // Delete the old logo if it exists
            $oldLogoPath = public_path('images/platform_logos/' . $entry->id . '.svg');
            if (File::exists($oldLogoPath)) {
                File::delete($oldLogoPath);
            }
    
            // Store the new logo
            $file = $request->file('logo');
            $file->move(public_path('images/platform_logos'), $entry->id . '.svg');
        }

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
                // Delete the platform image if it exists
                $logoPath = public_path('images/platform_logos/' . $entry->id . '.svg');
                if (File::exists($logoPath)) {
                    File::delete($logoPath);
                }
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

    private function validateName(Request $request, $id = null)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z\s]+$/',
                function ($attribute, $value, $fail) use ($request, $id) {
                    $lowercaseValue = strtolower($value);
                    switch ($request->type) {
                        case 'category':
                            $query = Category::whereRaw('LOWER(name) = ?', [$lowercaseValue]);
                            break;
                        case 'platform':
                            $query = Platform::whereRaw('LOWER(name) = ?', [$lowercaseValue]);
                            break;
                        case 'language':
                            $query = Language::whereRaw('LOWER(name) = ?', [$lowercaseValue]);
                            break;
                    }
                    if ($id) {
                        $query->where('id', '!=', $id);
                    }
                    if ($query->exists()) {
                        $fail('The ' . $request->type . ' name already exists.');
                    }
                },
            ],
        ]);
    }
}
