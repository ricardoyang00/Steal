<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    public function orderHistory($userId, Request $request)
    {
        if (!auth_user() || !auth_user()->buyer) {
            return redirect()->route('login');
        }

        $buyerId = auth_user()->buyer->id;

        // Default sorting options
        $sortBy = $request->get('sortBy', 'time');
        $direction = $request->get('direction', 'desc');

        // Fetch orders for the user
        $orders = Order::where('buyer', $buyerId)->get();

        // Map orders with additional data
        $orderHistory = $orders->map(function ($order) {
            $paymentMethodName = $order->getPayment->getPaymentMethod->name ?? 'Unknown';

            $deliveredPurchases = Purchase::where('order_', $order->id)
                ->whereHas('getDeliveredPurchase')
                ->get()
                ->map(function ($purchase) {
                    $delivered = $purchase->getDeliveredPurchase;
                    return [
                        'cdk' => $delivered->getCDK->code ?? 'No CDK',
                        'game' => $delivered->getCDK->getGame->name ?? 'Unknown Game',
                        'value' => $purchase->value,
                    ];
                });

            $totalPrice = $deliveredPurchases->sum('value');
            $formattedTime = $this->formatOrderTime($order->time);

            return [
                'order' => $order,
                'payment' => $paymentMethodName,
                'purchases' => $deliveredPurchases,
                'formattedTime' => $formattedTime,
                'totalPrice' => $totalPrice,
            ];
        });

        // Apply sorting
        if ($sortBy === 'totalPrice') {
            $orderHistory = $orderHistory->sortBy('totalPrice', SORT_REGULAR, $direction === 'desc');
        } else {
            $orderHistory = $orderHistory->sortBy(function ($history) {
                return $history['order']->time;
            }, SORT_REGULAR, $direction === 'desc');
        }

        return view('pages.purchase-history', compact('orderHistory'));
    }

    private function formatOrderTime($orderTime)
    {
        $orderDateTime = new \DateTime($orderTime);
        $currentDate = new \DateTime();

        if ($orderDateTime->format('Y-m-d') === $currentDate->format('Y-m-d')) {
            return 'Today at ' . $orderDateTime->format('H:i');
        }

        $yesterday = (clone $currentDate)->modify('-1 day');
        if ($orderDateTime->format('Y-m-d') === $yesterday->format('Y-m-d')) {
            return 'Yesterday at ' . $orderDateTime->format('H:i');
        }

        return $orderDateTime->format('Y-m-d H:i');
    }
}



