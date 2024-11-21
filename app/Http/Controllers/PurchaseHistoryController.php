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

        // Map orders to include only delivered purchases, payment method name, and formatted time
    $orderHistory = $orders->map(function ($order) {
        $paymentMethodName = $order->getPayment->getPaymentMethod->name ?? 'Unknown'; // Safely fetch payment method name

        // Fetch delivered purchases
        $deliveredPurchases = Purchase::where('order_', $order->id)
            ->whereHas('deliveredPurchase') // Ensure it's of type DeliveredPurchase
            ->get()
            ->map(function ($purchase) {
                // Access the DeliveredPurchase and related CDK and game
                $delivered = $purchase->deliveredPurchase;
                return [
                    'cdk' => $delivered->getCDK->code ?? 'No CDK', // Fetch CDK code
                    'game' => $delivered->getCDK->getGame->name ?? 'Unknown Game', // Fetch game name
                    'value' => $purchase->value, // Include purchase value
                ];
            });

        $formattedTime = $this->formatOrderTime($order->time);

        return [
            'order' => $order,
            'payment' => $paymentMethodName,
            'purchases' => $deliveredPurchases,
            'formattedTime' => $formattedTime,
        ];
    });

        return view('pages.purchase-history', compact('orderHistory'));
    }

    private function formatOrderTime($orderTime)
    {
        $orderDateTime = new \DateTime($orderTime);
        $currentDate = new \DateTime();

        // Check if the order time is today
        if ($orderDateTime->format('Y-m-d') === $currentDate->format('Y-m-d')) {
            return 'Today at ' . $orderDateTime->format('H:i');
        }

        // Check if the order time is yesterday
        $yesterday = (clone $currentDate)->modify('-1 day');
        if ($orderDateTime->format('Y-m-d') === $yesterday->format('Y-m-d')) {
            return 'Yesterday at ' . $orderDateTime->format('H:i');
        }

        // Return the full date for older orders
        return $orderDateTime->format('Y-m-d H:i');
    }

}



