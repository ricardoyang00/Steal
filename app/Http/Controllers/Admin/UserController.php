<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Search for users based on a query.
     */
    public function searchUsers(Request $request): View
    {
        $query = $request->input('query');
    
        if ($query) {
            $users = User::whereRaw('LOWER(username) LIKE ?', ['%' . strtolower($query) . '%'])
                ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($query) . '%'])
                ->get();
        } else {
            $users = collect(); // Return an empty collection if no query is provided
        }
    
        return view('admin.users.index', compact('users'));
    }

    /**
     * View a user's profile.
     */
    public function viewProfile($id): View
    {
        $user = User::findOrFail($id);
        return view('admin.users.profile', compact('user'));
    }

    /**
     * Change the username to a unique random 8-character string.
     */
    public function changeUsername($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $newUsername = $this->generateUniqueUsername();
        $user->username = $newUsername;
        $user->save();

        return redirect()->route('admin.users.profile', $user->id)
            ->with('success', 'Username changed successfully!');
    }

    /**
     * Change the name to a random 8-character string.
     */
    public function changeName($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->name = 'Name ' . $this->generateRandomString(8);
        $user->save();

        return redirect()->route('admin.users.profile', $user->id)
            ->with('success', 'Name changed successfully!');
    }

    /**
     * Generate a unique random username with the prefix "User ".
     */
    private function generateUniqueUsername(): string
    {
        do {
            $randomString = $this->generateRandomString(8);
            $newUsername = 'User ' . $randomString;
        } while (User::where('username', $newUsername)->exists());

        return $newUsername;
    }

    /**
     * Generate a random string of the specified length.
     */
    private function generateRandomString($length = 8): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Probably temporary functions as the number of users will scale too much
    /**
     * List all buyers and sellers.
     */
    public function listBuyersAndSellers(): View
    {
        $buyers = User::whereHas('buyer')->get();
        $sellers = User::whereHas('seller')->get();
        return view('admin.users.all-users', compact('buyers', 'sellers'));
    }
    /**
     * List all buyers.
     */
    /*public function listBuyers(): View
    {
        $buyers = User::whereHas('buyer')->get();
        return view('admin.users.buyers', compact('buyers'));
    }*/

    /**
     * List all sellers.
     */
    /*public function listSellers(): View
    {
        $sellers = User::whereHas('seller')->get();
        return view('admin.users.sellers', compact('sellers'));
    }*/
}
