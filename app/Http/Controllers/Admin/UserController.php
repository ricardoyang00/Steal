<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            $users = User::where('username', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
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
