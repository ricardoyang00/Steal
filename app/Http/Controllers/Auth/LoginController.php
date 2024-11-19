<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;

use App\Http\Controllers\ShoppingCartController;

class LoginController extends Controller
{

    /**
     * Display a login form.
     */
    public function showLoginForm()
    {
        if (auth_user()) {
            return redirect('/home');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $guards = ['web', 'admin'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();
                
                if (auth_user()->buyer) {
                    $buyerId = auth_user()->id;
                    $shoppingCart = $request->session()->get('shopping_cart', []);
                    $shoppingCartController = new ShoppingCartController();
                    $shoppingCartController->mergeShoppingCart($request, $shoppingCart);
                }
                $request->session()->forget('shopping_cart');
                
                return redirect()->intended('/home');
            }
        }
        

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        $guard = is_admin() ? 'admin' : 'web';

        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }
}
