<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $user = auth_user();

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

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth_user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('profile')
            ->with('success', 'Password updated successfully!');
    }
}
