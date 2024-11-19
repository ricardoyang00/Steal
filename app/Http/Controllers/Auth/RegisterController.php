<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;
use App\Models\Administrator;

use App\Rules\UniqueEmail;

class RegisterController extends Controller
{
    /**
     * Display a register form.
     */
    public function showRegistrationForm()
    {
        if (is_admin()) {
            return view('auth.register');
        }
    
        if (auth_user()) {
            return redirect('/home');
        }
    
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $rules = [
            'user_type' => 'required|in:buyer,seller,admin',
            'username' => 'required|string|max:15|unique:users',
            'name' => 'required|string|max:30',
            'email' => ['required', 'email', 'max:320', new UniqueEmail],
            'password' => 'required|min:8|confirmed',
        ];
    
        if ($request->user_type == 'buyer') {
            $rules['birth_date'] = 'required|date|before:today';
        }
    
        $request->validate($rules);

        if (is_admin() && $request->user_type == 'admin') {
            $admin = Administrator::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $user = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            if ($request->user_type == 'buyer') {
                $user->buyer()->create([
                    'id' => $user->id,
                    'nif' => null,
                    'birth_date' => $request->birth_date,
                    'coins' => 0,
                ]);
            } else if ($request->user_type == 'seller') {
                $user->seller()->create([
                    'id' => $user->id,
                ]);
            }
        }

        // Check if the request is from an admin
        if (is_admin()) {
            return redirect()->route('admin.users.search')
                ->withSuccess('Account created successfully!');
        }

        // Immediate login for regular user registration
        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('home')
            ->withSuccess('You have successfully registered & logged in!');
    }
}
