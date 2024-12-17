<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exception;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Exceptions\ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\ShoppingCartController;

class GoogleController extends Controller
{
    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle() {

        $google_user = Socialite::driver('google')->stateless()->user();
        $user = User::where('google_id', $google_user->getId())->first();
        
        // Check if a user with the same email already exists
        $existing_user = User::where('email', $google_user->getEmail())->first();
        if ($existing_user) {
            if ($existing_user->google_id) {
                // Log in the user if they have a Google ID
                Auth::login($existing_user);
                request()->session()->regenerate();

                if (auth_user()->buyer) {
                    $shoppingCart = request()->session()->get('shopping_cart', []);
                    $shoppingCartController = new ShoppingCartController();
                    $shoppingCartController->mergeShoppingCart(request(), $shoppingCart);
                }
                request()->session()->forget('shopping_cart');

                return redirect()->route('home')->withSuccess('You\'re in! The best deals and games are waiting for you.');
            } else {
                // Redirect with an error if the email is associated with another account without a Google ID
                return redirect()->route('login')->withErrors(['email' => 'The email is already associated with another account.']);
            }
        }

        // If the user does not exist, create one
        if (!$user) {

            $sanitized_name = $this->sanitizeName($google_user->getName());
            // Generate a unique username based on the user's name or email
            $username = $this->generateUniqueUsername($sanitized_name);

            // Store the provided name, email, and Google ID in the database
            $new_user = User::create([
                'username' => $username,
                'name' => $sanitized_name,
                'email' => $google_user->getEmail(),
                'is_active' => true,
                'is_blocked' => false,
                'google_id' => $google_user->getId(),
            ]);

            // Create a buyer record for the new user
            $new_user->buyer()->create([
                'id' => $new_user->id,
                'nif' => null,
                'birth_date' => '2000-01-01',
                'coins' => 500,
            ]);
            
            Auth::login($new_user);
            request()->session()->regenerate();
        
            if (auth_user()->buyer) {
                $shoppingCart = request()->session()->get('shopping_cart', []);
                $shoppingCartController = new ShoppingCartController();
                $shoppingCartController->mergeShoppingCart(request(), $shoppingCart);
            }
            request()->session()->forget('shopping_cart');

            return redirect()->route('home')->withSuccess('You\'re all set, gamer. Let’s unlock some new items!');
        // Otherwise, simply log in with the existing user
        } else {
            Auth::login($user);
            request()->session()->regenerate();

            if (auth_user()->buyer) {
                $shoppingCart = request()->session()->get('shopping_cart', []);
                $shoppingCartController = new ShoppingCartController();
                $shoppingCartController->mergeShoppingCart(request(), $shoppingCart);
            }
            request()->session()->forget('shopping_cart');

            return redirect()->route('home')->withSuccess('You\'re in! The best deals and games are waiting for you.');
        }
    }

    /**
     * Generate a unique username based on the provided name.
     */
    private function generateUniqueUsername($name)
    {
        // Remove everything that isn't a character or number
        $base_username = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
        // Ensure the base username does not exceed 15 characters
        $base_username = substr($base_username, 0, 15);
        $username = $base_username;
        $counter = 1;
    
        while (User::where('username', $username)->exists()) {
            $username = substr($base_username, 0, 15 - strlen((string)$counter)) . $counter;
            $counter++;
        }
    
        return $username;
    }

    /**
     * Sanitize the provided name to only contain characters, numbers, and spaces.
     */
    private function sanitizeName($name)
    {
        // Remove everything that isn't a character, number, or space
        $sanitized_name = preg_replace('/[^a-zA-Z0-9 ]/', '', $name);
        // Ensure the sanitized name does not exceed 30 characters
        return substr($sanitized_name, 0, 30);
    }
}
