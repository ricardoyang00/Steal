<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;


class PurchaseHistoryController extends Controller
{
    public function orderHistory($userId, Request $request)
    {
        if (!auth_user() || !auth_user()->buyer) {
            return redirect()->route('login');
        }

        $buyerId = auth_user()->buyer->id;

        $sortBy = $request->get('sortBy', 'time');
        $direction = $request->get('direction', 'desc');

        
        $ordersQuery = Order::where('buyer', $buyerId);

        if ($sortBy === 'totalPrice') {
            $ordersQuery->select('orders.*', DB::raw('(SELECT SUM(purchase.value) FROM purchase WHERE purchase.order_ = orders.id) AS total_cost'))
                ->orderBy('total_cost', $direction);
        } else {
            $ordersQuery->orderBy('time', $direction); // Default to sorting by time
        }

        $orders = $ordersQuery->paginate(5)->appends([
            'sortBy' => $sortBy,
            'direction' => $direction,
        ]);
        
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

        return view('pages.purchase-history', compact('orderHistory', 'orders'));
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



