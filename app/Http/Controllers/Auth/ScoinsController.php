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

        return view('pages.scoins');
    }

    public function history(Request $request)
    {
        $user = auth_user();
        if (!$user || !$user->buyer) {
            return redirect()->route('login');
        }
    
        $startingBalance = 500; // User starts with 500 S-Coins
    
        // Fetch all orders in ascending order for balance calculation
        $allOrders = Order::where('buyer', $user->id)
            ->with('getPayment')
            ->orderBy('time', 'asc')
            ->get();
    
        // Calculate the cumulative balance for all orders
        $calculatedBalances = [];
        foreach ($allOrders as $order) {
            $coinsGained = ceil($order->getPayment->value * 5);
            $startingBalance += $coinsGained - $order->coins;
            $calculatedBalances[$order->id] = $startingBalance;
        }
    
        // Fetch the paginated orders in descending order for display
        $orders = Order::where('buyer', $user->id)
            ->with('getPayment')
            ->orderBy('time', 'desc')
            ->paginate(10);
    
        return view('pages.scoins-history', [
            'orders' => $orders,
            'calculatedBalances' => $calculatedBalances,
        ]);
    }    
}