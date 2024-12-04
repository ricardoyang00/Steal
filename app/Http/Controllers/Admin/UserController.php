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
        $userQuery = $request->input('user_query');

        if ($userQuery) {
            $users = User::whereRaw('LOWER(username) LIKE ?', ['%' . strtolower($userQuery) . '%'])
                ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($userQuery) . '%'])
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
     * Reset the profile picture to default
     */
    public function resetPicture($id)
    {
        $user = User::findOrFail($id);

        // Set the profile picture to the default path
        $defaultPicturePath = 'images/profile_pictures/default-profile-picture.png';

        // Update the user's profile_picture field
        $user->profile_picture = $defaultPicturePath;
        $user->save();

        return redirect()->route('admin.users.profile', $user->id)
            ->withSuccess('Profile picture reset to default.');
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
            ->withSuccess('Username changed successfully!');
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
            ->withSuccess('Name changed successfully!');
    }

    /**
     * Generate a unique random username with the prefix "User ".
     */
    private function generateUniqueUsername(): string
    {
        do {
            $randomString = $this->generateRandomString(8);
            $newUsername = 'User_' . $randomString;
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

    /**
     * Change the number of coins for a buyer.
     */
    public function changeCoins(Request $request, $id): RedirectResponse
    {
        $maxCoins = 500000;
        
        $request->validate([
            'coins' => 'required|integer|min:0|max:' . $maxCoins,
        ]);

        $user = User::findOrFail($id);
        $buyer = $user->buyer;

        if ($buyer) {
            $buyer->coins = $request->input('coins');
            $buyer->save();
        }

        return redirect()->route('admin.users.profile', $user->id)
            ->withSuccess('Coins updated successfully!');
    }

    /* Block User */
    public function blockUser(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->is_blocked = true;
        $user->save();

        return redirect()->route('admin.users.profile', $user->id)
            ->withSuccess('User has been blocked successfully!');
    }

    /* Unblock User */
    public function unblockUser(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->is_blocked = false;
        $user->save();

        return redirect()->route('admin.users.profile', $user->id)
            ->withSuccess('User has been unblocked successfully!');
    }

    /* Deactivate User */
    public function adminDeactivateUser(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->is_active = false;
        $user->save();

        return redirect()->route('admin.users.profile', $user->id)
            ->withSuccess('User has been deactivated successfully!');
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
