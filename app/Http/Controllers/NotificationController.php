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

    public function createPriceWishlistNotifications($game, $oldPrice, $newPrice) {
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
                    'description' => "A game on your wishlist had its price updated. Game Name: {$game->name}, Old Price: $ {$oldPrice}, New Price: $ {$newPrice}, Type: Price",
                    'time' => now(),
                    'is_read' => false,
                    'wishlist' => $wishlist,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Error creating wishlist notifications: " . $e->getMessage());
        }
    } 

    public function createStockWishlistNotifications($game, $soldOut) {
        try {
            $wishlists = DB::table('wishlist')
                ->where('game', $game->id)
                ->pluck('id');
    
            if ($wishlists->isEmpty()) {
                return;
            }
    
            $description = $soldOut
                ? "A game on your wishlist has just sold out. '{$game->name}'"
                : "Good news! A game on your wishlist is now available again. Game Name:'{$game->name}', Type: Stock";
    
            foreach ($wishlists as $wishlist) {
                WishlistNotification::create([
                    'title' => "Stock Update for game on wishlist",
                    'description' => $description,
                    'time' => now(),
                    'is_read' => false,
                    'wishlist' => $wishlist,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Error creating stock wishlist notifications: " . $e->getMessage());
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
    
            $notifications = WishlistNotification::whereHas('getWishlist', function ($query) use ($buyerId) {
                $query->where('buyer', $buyerId);
            })
            ->orderBy('time', 'desc')
            ->get()
            ->map(function ($notification) {
                // Default notification array
                $parsedNotification = [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'description' => $notification->description,
                    'time' => $notification->time,
                    'is_read' => $notification->is_read,
                    'wishlist' => $notification->wishlist,
                ];
    
                // Extract the game name from the description using regex
                $gameName = null;
                if (preg_match("/Game Name: ?'?([^,']+)'?/", $notification->description, $gameNameMatches)) {
                    $gameName = $gameNameMatches[1] ?? null;
                }
    
                // Parse type-specific information
                if (strpos($notification->description, 'Type: Price') !== false) {
                    // Extract old price and new price using regex
                    $matches = [];
                    preg_match('/Old Price: \$([\d.]+), New Price: \$([\d.]+)/', $notification->description, $matches);
    
                    $oldPrice = $matches[1] ?? null;
                    $newPrice = $matches[2] ?? null;
    
                    // Remove the price and type details from the description
                    $cleanedDescription = preg_replace('/Old Price: \$[\d.]+, New Price: \$[\d.]+, Type: Price/', '', $notification->description);
    
                    // Add parsed details to the notification array
                    $parsedNotification['description'] = trim($cleanedDescription);
                    $parsedNotification['old_price'] = $oldPrice;
                    $parsedNotification['new_price'] = $newPrice;
                    $parsedNotification['type'] = 'Price';
                } elseif (strpos($notification->description, 'Type: Stock') !== false) {
                    $parsedNotification['type'] = 'Stock';
                } else {
                    $parsedNotification['type'] = 'Unknown';
                }
    
                $parsedNotification['game_name'] = $gameName;
    
                return $parsedNotification;
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