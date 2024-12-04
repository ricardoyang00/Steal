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
                
                if (!is_admin() && auth_user()->is_blocked) {
                    Auth::guard($guard)->logout();
                    return back()->withErrors([
                        'Your account has been suspended. Please contact us for further assistance.',
                    ])->onlyInput('email');
                }

                if (auth_user()->buyer) {
                    $shoppingCart = $request->session()->get('shopping_cart', []);
                    $shoppingCartController = new ShoppingCartController();
                    $shoppingCartController->mergeShoppingCart($request, $shoppingCart);
                }
                $request->session()->forget('shopping_cart');
                
                return redirect()->intended('/home')
                    ->withSuccess('You\'re in! The best deals and games are waiting for you.');
            }
        }
        

        return back()->withErrors([
            'The provided credentials do not match our records.',
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
            ->withSuccess('You\'re logged out. Ready to respawn anytime!');
    }
}
