<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;

use App\Models\User;

class ProfileController extends Controller
{
    public function showProfile(): View
    {
        return view('pages.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'username' => 'required|string|max:15|unique:users,username,' . $user->id,
            'name' => 'required|string|max:30',
        ];

        if ($user->buyer) {
            $rules['nif'] = 'nullable|digits:9';
        }

        $request->validate($rules);

        $user->username = $request->input('username');
        $user->name = $request->input('name');
        
        if ($user->buyer) {
            $user->buyer->nif = $request->input('nif');
            $user->buyer->save();
        }
        $user->save();
        return redirect()->route('profile')
            ->withSuccess('Profile updated successfully!');
    }
}
