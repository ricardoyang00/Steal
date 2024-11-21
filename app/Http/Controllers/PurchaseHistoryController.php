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

        $orders = Order::where('buyer', $buyerId)->get();

    $orderHistory = $orders->map(function ($order) {
        $paymentMethodName = $order->getPayment->getPaymentMethod->name ?? 'Unknown';

        $deliveredPurchases = Purchase::where('order_', $order->id)
            ->whereHas('deliveredPurchase')
            ->get()
            ->map(function ($purchase) {
                $delivered = $purchase->deliveredPurchase;
                return [
                    'cdk' => $delivered->getCDK->code ?? 'No CDK',
                    'game' => $delivered->getCDK->getGame->name ?? 'Unknown Game',
                    'value' => $purchase->value,
                ];
            });

        $formattedTime = $this->formatOrderTime($order->time);

        $totalPrice = $deliveredPurchases->sum('value');

        return [
            'order' => $order,
            'payment' => $paymentMethodName,
            'purchases' => $deliveredPurchases,
            'formattedTime' => $formattedTime,
            'totalPrice' => $totalPrice,
        ];
    });

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



