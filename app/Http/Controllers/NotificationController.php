<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\ShoppingCart;
use App\Models\Game;
use App\Models\OrderNotification;
use App\Models\WishlistNotification;
use App\Models\ShoppingCartNotification;
use App\Models\GameNotification;
use Illuminate\Support\Facades\DB;
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

    public function createPriceNotifications($game, $oldPrice, $newPrice) {
        try {
            // Create Wishlist Notifications
            $wishlists = DB::table('wishlist')
                ->where('game', $game->id)
                ->pluck('id');
    
            foreach ($wishlists as $wishlist) {
                WishlistNotification::create([
                    'title' => "Wishlist Game Price Update",
                    'description' => "A game on your wishlist had its price updated. Game Name: {$game->name}, Old Price: $ {$oldPrice}, New Price: $ {$newPrice}, Type: Price",
                    'time' => now(),
                    'is_read' => false,
                    'wishlist' => $wishlist,
                ]);
            }
    
            $shoppingCarts = DB::table('shoppingcart')
                ->where('game', $game->id)
                ->pluck('id');
    
            foreach ($shoppingCarts as $shoppingCart) {
                ShoppingCartNotification::create([
                    'title' => "Shopping Cart Game Price Update",
                    'description' => "A game on your shopping cart had its price updated. Game Name: {$game->name}, Old Price: $ {$oldPrice}, New Price: $ {$newPrice}, Type: Price",
                    'time' => now(),
                    'is_read' => false,
                    'shopping_cart' => $shoppingCart,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Error creating price notifications: " . $e->getMessage());
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

    public function createGameNotifications($purchasedItems) {
        try {
            $gamePurchases = [];
    
            foreach ($purchasedItems as $item) {
                $game = $item['game'];
                $value = $item['value'];
                $gameId = $game->id;
    
                if (!isset($gamePurchases[$gameId])) {
                    $gamePurchases[$gameId] = [
                        'game' => $game,
                        'quantity' => 0,
                        'totalValue' => 0.0,
                    ];
                }
    
                $gamePurchases[$gameId]['quantity'] += 1;
                $gamePurchases[$gameId]['totalValue'] += $value;
            }
    
            foreach ($gamePurchases as $data) {
                $game = $data['game'];
                $quantity = $data['quantity'];
                $totalValue = $data['totalValue'];
    
                GameNotification::create([
                    'title' => "Game Sold",
                    'description' => "One of your games has been purchased. GameName: {$game->name}, quantity: {$quantity}, totalPrice: {$totalValue}",
                    'time' => now(),
                    'is_read' => false,
                    'game' => $game->id,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Error creating game notifications: " . $e->getMessage());
        }
    }
    
    
    
    private function getNotifications() {
        $orderNotifications = $this->getOrderNotifications()->toArray();
        $reviewNotifications = $this->getReviewNotifications()->toArray();
        $gameNotifications = $this->getGameNotifications()->toArray();
        $wishlistNotifications = $this->getWishlistNotifications()->toArray();
        $shoppingCartNotifications = $this->getShoppingCartNotifications()->toArray();
    
        $notifications = array_merge(
            $orderNotifications,
            $reviewNotifications,
            $gameNotifications,
            $wishlistNotifications,
            $shoppingCartNotifications
        );
    
        usort($notifications, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
    
        // Pagination
        $perPage = 6; // Number of notifications per page
        $currentPage = request()->get('page', 1); // Get the current page from the request, default to 1
        $currentItems = array_slice($notifications, ($currentPage - 1) * $perPage, $perPage);

    
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

                $notification->type = 'Order';
    
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
        try {
            $sellerId = auth_user()->id;
    
            $notifications = GameNotification::whereHas('getGame', function ($query) use ($sellerId) {
                $query->where('owner', $sellerId);
            })
            ->get()
            ->map(function ($notification) {
                // Set the notification type
                $notification->type = 'Game';
    
                // Default parsed details
                $parsedNotification = [
                    'game_name' => null,
                    'quantity' => null,
                    'total_price' => null,
                ];
    
                if (preg_match('/GameName:\s?([^,]+),\s?quantity:\s?(\d+),\s?totalPrice:\s?([\d.]+)/', $notification->description, $matches)) {
                    $parsedNotification['game_name'] = $matches[1] ?? null;
                    $parsedNotification['quantity'] = $matches[2] ?? null;
                    $parsedNotification['total_price'] = $matches[3] ?? null;
                }
    
                $notification->parsedDetails = $parsedNotification;
    
                return $notification;
            });
    
            return $notifications;
        } catch (\Exception $e) {
            \Log::error("Error fetching game notifications: " . $e->getMessage());
            return collect();
        }
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

                $notification->type = 'Wishlist';
    

                $parsedNotification = [
                    'game_name' => null,
                    'specific_type' => 'Unknown',
                ];
    
                // Extract the game name from the description using regex
                if (preg_match("/Game Name: ?'?([^,']+)'?/", $notification->description, $gameNameMatches)) {
                    $parsedNotification['game_name'] = $gameNameMatches[1] ?? null;
                }
    
                // Parse specific details based on the description
                if (strpos($notification->description, 'Type: Price') !== false) {
                    // Extract old price and new price using regex
                    $matches = [];
                    preg_match('/Old Price: \$\s?(\d+(?:\.\d{1,2})?), New Price: \$\s?(\d+(?:\.\d{1,2})?)/', $notification->description, $matches);
                    $parsedNotification['specific_type'] = 'Price';
                    $parsedNotification['old_price'] = $matches[1] ?? null;
                    $parsedNotification['new_price'] = $matches[2] ?? null;
    
                    // Remove the price details from the description
                    $notification->description = preg_replace('/Game Name: ?\'?[^,]+\'?, Old Price: \$\s?\d+(?:\.\d{1,2})?, New Price: \$\s?\d+(?:\.\d{1,2})?, Type: Price/', '', $notification->description);


                } elseif (strpos($notification->description, 'Type: Stock') !== false) {
                    $parsedNotification['specific_type'] = 'Stock';
                }
    
                // Add the parsed details to the notification
                $notification->parsedDetails = $parsedNotification;
    
                return $notification;
            });
    
            return $notifications;
        } catch (\Exception $e) {
            \Log::error("Error fetching wishlist notifications: " . $e->getMessage());
            return collect();
        }
    }

    private function getShoppingCartNotifications() {
        try {
            $buyerId = auth_user()->id;
    
            $notifications = ShoppingCartNotification::whereHas('getShoppingCart', function ($query) use ($buyerId) {
                $query->where('buyer', $buyerId);
            })
            ->orderBy('time', 'desc')
            ->get()
            ->map(function ($notification) {
                // Set the general notification type
                $notification->type = 'ShoppingCart';
    
                // Default parsed details
                $parsedNotification = [
                    'game_name' => null,
                    'specific_type' => 'Unknown',
                ];
    
                // Extract the game name from the description using regex
                if (preg_match("/Game Name: ?'?([^,']+)'?/", $notification->description, $gameNameMatches)) {
                    $parsedNotification['game_name'] = $gameNameMatches[1] ?? null;
                }
    
                // Parse specific details based on the description
                if (strpos($notification->description, 'Type: Price') !== false) {
                    // Extract old price and new price using regex
                    $matches = [];
                    preg_match('/Old Price: \$\s?(\d+(?:\.\d{1,2})?), New Price: \$\s?(\d+(?:\.\d{1,2})?)/', $notification->description, $matches);
                    $parsedNotification['specific_type'] = 'Price';
                    $parsedNotification['old_price'] = $matches[1] ?? null;
                    $parsedNotification['new_price'] = $matches[2] ?? null;
    
                    // Remove the price details from the description
                    $notification->description = preg_replace('/Game Name: ?\'?[^,]+\'?, Old Price: \$\s?\d+(?:\.\d{1,2})?, New Price: \$\s?\d+(?:\.\d{1,2})?, Type: Price/', '', $notification->description);
    
                } elseif (strpos($notification->description, 'Type: Stock') !== false) {
                    $parsedNotification['specific_type'] = 'Stock';
                }
    
                // Add the parsed details to the notification
                $notification->parsedDetails = $parsedNotification;
    
                return $notification;
            });
    
            return $notifications;
        } catch (\Exception $e) {
            \Log::error("Error fetching shopping cart notifications: " . $e->getMessage());
            return collect();
        }
    }
    
    

    public function markNotificationAsRead($notificationId)
{
    try {
        $notification = OrderNotification::find($notificationId) ??
                        WishlistNotification::find($notificationId) ??
                        ShoppingCartNotification::find($notificationId) ??
                        GameNotification::find($notificationId);

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        if (!$notification->is_read) {
            $notification->update(['is_read' => true]);
        }

        return response()->json(['message' => 'Notification marked as read'], 200);

    } catch (\Exception $e) {
        \Log::error('Error marking notification as read: ' . $e->getMessage());
        return response()->json(['error' => 'Unable to mark notification as read'], 500);
    }
}

    

    public function getUnreadCount() {
        try {
            if(auth_user()){

                $unreadCount = 0;

                if(auth_user()->buyer){

                    $buyerId = auth_user()->id;

                    $userOrders = Order::where('buyer', $buyerId)->pluck('id');
                    $unreadOrderNotifications = OrderNotification::whereIn('order_', $userOrders)
                    ->where('is_read', false)
                    ->count();

                    $userWishlists = Wishlist::where('buyer', $buyerId)->pluck('id');
                    $unreadWishlistNotifications = WishlistNotification::whereIn('wishlist', $userWishlists)
                    ->where('is_read', false)
                    ->count();

                    $userShoppingCarts = ShoppingCart::where('buyer', $buyerId)->pluck('id');
                    $unreadShoppingCartNotifications = ShoppingCartNotification::whereIn('shopping_cart', $userShoppingCarts)
                    ->where('is_read', false)
                    ->count();

                    $unreadCount = $unreadOrderNotifications + $unreadWishlistNotifications + $unreadShoppingCartNotifications;
    
                }


                else if(auth_user()->seller){

                    $sellerId = auth_user()->id;
                    $sellerGames = Game::where('owner', $sellerId)->pluck('id');
                    $unreadGameNotifications = GameNotification::whereIn('game', $sellerGames)
                    ->where('is_read', false)
                    ->count();
                    
                    $unreadCount = $unreadGameNotifications;

                }
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
        $notification = null;

        $notification = OrderNotification::find($notificationId) ??
                        WishlistNotification::find($notificationId) ??
                        ShoppingCartNotification::find($notificationId) ??
                        GameNotification::find($notificationId);

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        if ($notification instanceof OrderNotification) {
            if ($notification->getOrder && $notification->getOrder->buyer === auth()->id()) {
                $notification->delete();
                return response()->json(['message' => 'Order notification deleted successfully'], 200);
            }
        } elseif ($notification instanceof WishlistNotification) {
            if ($notification->getWishlist && $notification->getWishlist->buyer === auth()->id()) {
                $notification->delete();
                return response()->json(['message' => 'Wishlist notification deleted successfully'], 200);
            }
        } elseif ($notification instanceof ShoppingCartNotification) {
            if ($notification->getShoppingCart && $notification->getShoppingCart->buyer === auth()->id()) {
                $notification->delete();
                return response()->json(['message' => 'Game notification deleted successfully'], 200);
            }
        } elseif ($notification instanceof GameNotification) {
            if ($notification->getGame && $notification->getGame->seller === auth()->id()) {
                $notification->delete();
                return response()->json(['message' => 'Game notification deleted successfully'], 200);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    } catch (\Exception $e) {
        \Log::error('Error deleting notification: ' . $e->getMessage());
        return response()->json(['error' => 'Unable to delete notification'], 500);
    }
}



    
    

}