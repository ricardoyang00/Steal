<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Order;
use App\Models\OrderNotification;
use Exception;

class NotificationController extends Controller{
    public function index() {
        if (auth_user()) {
            return view('pages/notifications', 
                ['notifications' => $this->getNotifications()]
            );
        } else {
            return redirect()->route('login');
        }
    }

    public function createWishlistNotifications($game, $oldPrice, $newPrice) {
        try {
            $wishlists = DB::table('wishlist_game')
                ->where('game_id', $game->id)
                ->pluck('wishlist_id');
    
            if ($wishlists->isEmpty()) {
                return;
            }
    
            foreach ($wishlists as $wishlist) {
                WishlistNotification::create([
                    'title' => "Update on price of wishlist game",
                    'description' => "A game on your wishlist had its price updated. Game Name: {$game->name}, Old Price: $ {$oldPrice}, New Price: $ {$newPrice}",
                    'time' => now(),
                    'is_read' => false,
                    'wishlist' => $wishlist,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Error creating wishlist notifications: " . $e->getMessage());
        }
    }    
    

    private function getNotifications() {
        $orderNotifications = $this->getOrderNotifications()->toArray();
        $reviewNotifications = $this->getReviewNotifications()->toArray();
        $gameNotifications = $this->getGameNotifications()->toArray();
        $wishlistNotifications = $this->getWishlistNotifications()->toArray();
    
        $notifications = array_merge(
            $orderNotifications,
            $reviewNotifications,
            $gameNotifications,
            $wishlistNotifications
        );
    
        usort($notifications, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
    
        // Pagination
        $perPage = 6; // Number of notifications per page
        $currentPage = request()->get('page', 1); // Get the current page from the request, default to 1
        $currentItems = array_slice($notifications, ($currentPage - 1) * $perPage, $perPage);

        $this->markNotificationsAsRead($currentItems);
    
        return new LengthAwarePaginator(
            $currentItems, // Items for the current page
            count($notifications), // Total number of items
            $perPage, // Items per page
            $currentPage, // Current page
            ['path' => request()->url(), 'query' => request()->query()] // Maintain query parameters in pagination links
        );
    }

    private function getOrderNotifications() {
        try {
            $buyerId = auth_user()->id;
    
            $notifications = OrderNotification::whereHas('getOrder', function ($query) use ($buyerId) {
                $query->where('buyer', $buyerId);
            })
            ->with(['getOrder.getPurchases.getDeliveredPurchase.getCDK.getGame', 'getOrder.getPurchases.getCanceledPurchase.getGame']) // Eager load related models
            ->orderBy('time', 'desc')
            ->get();
    
            return $notifications->map(function ($notification) {
                $order = $notification->getOrder;
    
                if ($order) {

                    $formattedOrderDate = (new \DateTime($order->time))->format('F d, Y H:i');

                    $purchases = $order->getPurchases;
    
                    $details = $purchases->map(function ($purchase) {
                        if ($purchase->getDeliveredPurchase) {
                            $game = $purchase->getDeliveredPurchase->getCDK->getGame ?? null;
                            return [
                                'type' => 'Delivered',
                                'gameName' => $game->name ?? 'Unknown Game',
                                'value' => $purchase->getValue(),
                            ];
                        } elseif ($purchase->getCanceledPurchase) {
                            $game = $purchase->getCanceledPurchase->getGame ?? null;
                            return [
                                'type' => 'Canceled',
                                'gameName' => $game->name ?? 'Unknown Game',
                                'value' => $purchase->getValue(),
                            ];
                        }
                        return null;
                    })->filter();
    
                    $notification->orderDetails = [
                        'date' => $formattedOrderDate,
                        'purchases' => $details->toArray(),
                        'totalPrice' => $purchases->sum('value'),
                    ];
                }
    
                return $notification;
            });
        } catch (\Exception $e) {
            \Log::error("Error fetching order notifications: " . $e->getMessage());
            return collect();
        }
    }
    
    
    private function getReviewNotifications() {
        // TODO
        return collect();
    }

    private function getGameNotifications() {
        // TODO
        return collect();
    }

    private function getWishlistNotifications() {
        try {
            $buyerId = auth_user()->id;
    
            $notifications = WishlistNotification::whereHas('getWishlist', function ($query) use ($userId) {
                $query->where('buyer', $buyerId);
            })
            ->orderBy('time', 'desc')
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'description' => $notification->description,
                    'time' => $notification->time,
                    'is_read' => $notification->is_read,
                    'wishlist' => $notification->wishlist,
                ];
            });
    
            return $notifications;
        } catch (\Exception $e) {
            \Log::error("Error fetching wishlist notifications: " . $e->getMessage());
            return collect();
        }
    }

    private function markNotificationsAsRead($notifications) {
        $unreadNotificationIds = array_map(function ($notification) {
            return !$notification['is_read'] ? $notification['id'] : null;
        }, $notifications);
    
        // Filter out null values
        $unreadNotificationIds = array_filter($unreadNotificationIds);
    
        if (!empty($unreadNotificationIds)) {
            OrderNotification::whereIn('id', $unreadNotificationIds)->update(['is_read' => true]);
        }
    }
    

    public function getUnreadCount() {
        try {
            if(auth_user()){
                $userOrders = Order::where('buyer', auth()->id())->pluck('id');
                $unreadCount = OrderNotification::whereIn('order_', $userOrders)
                ->where('is_read', false)
                ->count();
    
                return response()->json(['unread_count' => $unreadCount], 200);
            }
        } catch (\Exception $e) {
            \Log::error("Error fetching unread notifications count: " . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch unread notifications count'], 500);
        }
    }
    

    public function deleteNotification($notificationId)
{
    try {
        $notification = OrderNotification::findOrFail($notificationId);

        if ($notification->getOrder && $notification->getOrder->buyer === auth()->id()) {
            $notification->delete();
            return response()->json(['message' => 'Notification deleted successfully'], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    } catch (\Exception $e) {
        \Log::error('Error deleting notification: ' . $e->getMessage());
        return response()->json(['error' => 'Unable to delete notification'], 500);
    }
}


    
    

}