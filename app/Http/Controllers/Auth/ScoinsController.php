<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScoinsController extends Controller
{
    public function index()
    {
        $user = auth_user();
        if (!$user || !$user->buyer) {
            return redirect()->route('login');
        }

        $orders = Order::where('buyer', $user->id)->with('getPayment')->get();

        return view('pages.scoins', compact('orders'));
    }
}