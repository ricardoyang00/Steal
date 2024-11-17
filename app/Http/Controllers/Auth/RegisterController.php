<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'user_type' => 'required|in:buyer,seller',
            'username' => 'required|string|max:15|unique:users',
            'name' => 'required|string|max:30',
            'email' => 'required|email|max:320|unique:users',
            'password' => 'required|min:8|confirmed',
            'birth_date' => 'required_if:user_type,buyer|date|before:today',
        ]);

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
        return redirect()->route('helloworld')
            ->withSuccess('You have successfully registered & logged in!');
    }

    /**
     * Display the admin registration form.
     */
    public function showAdminRegistrationForm(): View
    {
        return view('admin.register');
    }
}
