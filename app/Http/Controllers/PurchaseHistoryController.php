<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    public function orderHistory($userId)
    {
        if (!auth_user()) {
            return redirect()->route('login');
        }
        if (!auth_user()->buyer) {
            return redirect()->route('login');
        }
        $buyerId = auth_user()->id;

        // Fetch orders for the user
        $orders = Order::where('buyer', $buyerId)->get();

        // Map orders to include purchases and payment method name
        $orderHistory = $orders->map(function ($order) {
            $paymentMethodName = $order->getPayment->getPaymentMethod->name;
            $purchases = Purchase::where('order_', $order->id)->get();

            return [
                'order' => $order,
                'payment' => $paymentMethodName,
                'purchases' => $purchases,
            ];
        });

        return view('pages.purchase-history', compact('orderHistory'));
    }
}

