<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\ShoppingCart;
use App\Models\Game;
use App\Models\Notification;
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

    public function fetchNotificationsJSON() {
        if (auth_user()) {
            $notifications = $this->getNotifications();
            $notificationsArray = $notifications->toArray();
    
            // $notificationsArray has pagination info and 'data' => [...] key containing the notifications
            // Return only the 'data' array so the frontend can do notifications.forEach(...)
            return response()->json(['notifications' => $notificationsArray['data']], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    
    

    public function createOrderNotification($order, $purchasedItems, $canceledItems) {
        $title = 'Order Processed';
        $description = '';
    
        if (empty($purchasedItems) && !empty($canceledItems)) {
            $description = 'Your order could not be completed. ';
            $description .= 'Unfortunately, none of the items in your order were available due to insufficient stock.';
        } elseif (empty($canceledItems)) {
            $description = 'Your order was successfully completed. All items have been purchased.';
        } else {
            $description = 'Your order was partially completed. ';
            $description .= 'Unfortunately, the following items could not be purchased, due to insufficient stock: ';
            $canceledGameNames = array_column($canceledItems, 'gameName');
            $description .= implode(', ', $canceledGameNames) . '.';
        }
    
        try {
            // Create the base notification
            $notification = Notification::create([
                'title' => $title,
                'description' => $description,
                'time' => now(),
                'is_read' => false,
            ]);
    
            // Create the specialized notification linking to the order
            OrderNotification::create([
                'id' => $notification->id,
                'order_' => $order->id,
            ]);
        } catch (\Exception $e) {
            \Log::error("Error creating order notification: " . $e->getMessage());
        }
    }    

    public function createPriceNotifications($game, $oldPrice, $newPrice) {
        try {
            $gameName = $game->name;
    
            // Fetch related wishlists
            $wishlists = DB::table('wishlist')
                ->where('game', $game->id)
                ->pluck('id');
    
            foreach ($wishlists as $wishlist) {
                $notification = Notification::create([
                    'title' => "Wishlist Game Price Update",
                    'description' => "A game on your wishlist had its price updated. Game Name: {$gameName}, Old Price: $ {$oldPrice}, New Price: $ {$newPrice}, Type: Price",
                    'time' => now(),
                    'is_read' => false,
                ]);
    
                WishlistNotification::create([
                    'id' => $notification->id,
                    'wishlist' => $wishlist,
                ]);
            }
    
            $shoppingCarts = DB::table('shoppingcart')
                ->where('game', $game->id)
                ->pluck('id');
    
            foreach ($shoppingCarts as $shoppingCart) {
                $notification = Notification::create([
                    'title' => "Shopping Cart Game Price Update",
                    'description' => "A game on your shopping cart had its price updated. Game Name: {$gameName}, Old Price: $ {$oldPrice}, New Price: $ {$newPrice}, Type: Price",
                    'time' => now(),
                    'is_read' => false,
                ]);
    
                ShoppingCartNotification::create([
                    'id' => $notification->id,
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
    
                $notification = Notification::create([
                    'title' => "Game Sold",
                    'description' => "One of your games has been purchased. GameName: {$game->name}, quantity: {$quantity}, totalPrice: {$totalValue}",
                    'time' => now(),
                    'is_read' => false,
                ]);
    
                GameNotification::create([
                    'id' => $notification->id,
                    'game' => $game->id,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Error creating game notifications: " . $e->getMessage());
        }
    }    

    public function createReviewNotifications($review){
        try {
            $reviewAuthor = $review->getAuthor->user->username;
            $gameName = $review->getGame->name;
            $reviewType = $review->is_positive ? 'positive' : 'negative';
    
            $notification = Notification::create([
                'title' => "Game Reviewed",
                'description' => "One of your games has been reviewed. Review Author: {$reviewAuthor}, Reviewed Game: {$gameName}, reviewType: {$reviewType}",
                'time' => now(),
                'is_read' => false,
            ]);
    
            // Create the specialized notification linking to the review
            NotificationReview::create([
                'id' => $notification->id,
                'review' => $review->id,
            ]);
        } catch (\Exception $e) {
            \Log::error("Error creating review notification: " . $e->getMessage());
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
            ->with([
                'getNotification', 
                'getOrder.getPurchases.getDeliveredPurchase.getCDK.getGame', 
                'getOrder.getPurchases.getCanceledPurchase.getGame'
            ])
            ->get();
    
            // Sort by notification time descending
            $notifications = $notifications->sortByDesc(fn($notification) => $notification->getNotification->time)->values();
    
            return $notifications->map(function ($notification) {
                $notification->title = $notification->getNotification->title;
                $notification->description = $notification->getNotification->description;
                $notification->time = $notification->getNotification->time;
                $notification->is_read = $notification->getNotification->is_read;
    
                $notification->type = 'Order';
    
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
        try {
            $sellerId = auth_user()->id;
    
            $notifications = NotificationReview::whereHas('getReview.getGame', function ($query) use ($sellerId) {
                $query->where('owner', $sellerId);
            })
            ->with(['getNotification', 'getReview.getGame', 'getReview.author'])
            ->get();
    
            // Sort by notification time descending
            $notifications = $notifications->sortByDesc(fn($n) => $n->getNotification->time)->values();
    
            return $notifications->map(function ($notification) {
                // Set notification type
                $notification->type = 'Review';
    
                // Extract fields from the related Notification record
                $title = $notification->getNotification->title;
                $desc = $notification->getNotification->description;
                $time = $notification->getNotification->time;
                $isRead = $notification->getNotification->is_read;
    
                // Assign fields to the notification for convenience
                $notification->title = $title;
                $notification->description = $desc;
                $notification->time = $time;
                $notification->is_read = $isRead;
    
                $parsedNotification = [
                    'game_name' => null,
                    'review_author' => null,
                    'review_type' => null,
                ];
    
                // The description format is:
                // "One of your games has been reviewed. Review Author: {author}, Reviewed Game: {gameName}, reviewType: {positive/negative}"
                if (preg_match('/Review Author:\s?([^,]+),\s?Reviewed Game:\s?([^,]+),\s?reviewType:\s?(positive|negative)/', $desc, $matches)) {
                    $parsedNotification['review_author'] = $matches[1] ?? null;
                    $parsedNotification['game_name'] = $matches[2] ?? null;
                    $parsedNotification['review_type'] = $matches[3] ?? null;
    
                    // Remove the parsed details from the description
                    $desc = preg_replace('/Review Author:\s?[^,]+,\s?Reviewed Game:\s?[^,]+,\s?reviewType:\s?(positive|negative)/', '', $desc);
                    $desc = trim($desc);
                    $notification->description = $desc;
                }
    
                $notification->parsedDetails = $parsedNotification;
    
                return $notification;
            });
        } catch (\Exception $e) {
            \Log::error("Error fetching review notifications: " . $e->getMessage());
            return collect();
        }
    }
    

    private function getGameNotifications() {
        try {
            $sellerId = auth_user()->id;
    
            $notifications = GameNotification::whereHas('getGame', function($query) use ($sellerId) {
                $query->where('owner', $sellerId);
            })
            ->with(['getNotification','getGame'])
            ->get();
    
            $notifications = $notifications->sortByDesc(fn($n) => $n->getNotification->time)->values();
    
            return $notifications->map(function ($notification) {
                // Set notification type
                $notification->type = 'Game';
    
                $title = $notification->getNotification->title;
                $desc = $notification->getNotification->description;
                $time = $notification->getNotification->time;
                $isRead = $notification->getNotification->is_read;
    
                // Default parsed details
                $parsedNotification = [
                    'game_name' => null,
                    'quantity' => null,
                    'total_price' => null,
                ];
    
                if (preg_match('/GameName:\s?([^,]+),\s?quantity:\s?(\d+),\s?totalPrice:\s?([\d.]+)/', $desc, $matches)) {
                    $parsedNotification['game_name'] = $matches[1] ?? null;
                    $parsedNotification['quantity'] = $matches[2] ?? null;
                    $parsedNotification['total_price'] = $matches[3] ?? null;
    
                    // Remove parsed details from the description
                    $desc = preg_replace('/GameName:\s?[^,]+,\s?quantity:\s?\d+,\s?totalPrice:\s?[\d.]+/', '', $desc);
                    $desc = trim($desc);
                }
    
                $notification->title = $title;
                $notification->description = $desc;
                $notification->time = $time;
                $notification->is_read = $isRead;
                $notification->parsedDetails = $parsedNotification;
    
                return $notification;
            });
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
            ->with(['getNotification', 'getWishlist'])
            ->get();
    
            $notifications = $notifications->sortByDesc(fn($n) => $n->getNotification->time)->values();
    
            return $notifications->map(function ($notification) {
                $notification->type = 'Wishlist';
    
                $title = $notification->getNotification->title;
                $desc = $notification->getNotification->description;
                $time = $notification->getNotification->time;
                $isRead = $notification->getNotification->is_read;
    
                $notification->title = $title;
                $notification->description = $desc;
                $notification->time = $time;
                $notification->is_read = $isRead;
    
                $parsedNotification = [
                    'game_name' => null,
                    'specific_type' => 'Unknown',
                ];
    
                if (preg_match("/Game Name: ?'?([^,']+)'?/", $desc, $gameNameMatches)) {
                    $parsedNotification['game_name'] = $gameNameMatches[1] ?? null;
                }
    
                if (strpos($desc, 'Type: Price') !== false) {
                    $matches = [];
                    if (preg_match('/Old Price: \$\s?(\d+(?:\.\d{1,2})?), New Price: \$\s?(\d+(?:\.\d{1,2})?)/', $desc, $matches)) {
                        $parsedNotification['specific_type'] = 'Price';
                        $parsedNotification['old_price'] = $matches[1] ?? null;
                        $parsedNotification['new_price'] = $matches[2] ?? null;
                    }
    
                    // Remove the price details from the description
                    $desc = preg_replace('/Game Name: ?\'?[^,]+\'?, Old Price: \$\s?\d+(?:\.\d{1,2})?, New Price: \$\s?\d+(?:\.\d{1,2})?, Type: Price/', '', $desc);
                    $desc = trim($desc);
                    $notification->description = $desc;
    
                } elseif (strpos($desc, 'Type: Stock') !== false) {
                    $parsedNotification['specific_type'] = 'Stock';
                }
    
                // Add the parsed details to the notification
                $notification->parsedDetails = $parsedNotification;
    
                return $notification;
            });
    
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
            ->with(['getNotification','getShoppingCart'])
            ->get();
    
            // Sort by notification time descending
            $notifications = $notifications->sortByDesc(fn($n) => $n->getNotification->time)->values();
    
            return $notifications->map(function ($notification) {
    
                $notification->type = 'ShoppingCart';
    
                $title = $notification->getNotification->title;
                $desc = $notification->getNotification->description;
                $time = $notification->getNotification->time;
                $isRead = $notification->getNotification->is_read;
    
                $notification->title = $title;
                $notification->description = $desc;
                $notification->time = $time;
                $notification->is_read = $isRead;
    
                $parsedNotification = [
                    'game_name' => null,
                    'specific_type' => 'Unknown',
                ];
    
                if (preg_match("/Game Name: ?'?([^,']+)'?/", $desc, $gameNameMatches)) {
                    $parsedNotification['game_name'] = $gameNameMatches[1] ?? null;
                }
    
                if (strpos($desc, 'Type: Price') !== false) {
                    $matches = [];
                    if (preg_match('/Old Price: \$\s?(\d+(?:\.\d{1,2})?), New Price: \$\s?(\d+(?:\.\d{1,2})?)/', $desc, $matches)) {
                        $parsedNotification['specific_type'] = 'Price';
                        $parsedNotification['old_price'] = $matches[1] ?? null;
                        $parsedNotification['new_price'] = $matches[2] ?? null;
                    }
    
                    $desc = preg_replace('/Game Name: ?\'?[^,]+\'?, Old Price: \$\s?\d+(?:\.\d{1,2})?, New Price: \$\s?\d+(?:\.\d{1,2})?, Type: Price/', '', $desc);
                    $desc = trim($desc);
                    $notification->description = $desc;
    
                } elseif (strpos($desc, 'Type: Stock') !== false) {
                    $parsedNotification['specific_type'] = 'Stock';
                }
    
                // Add the parsed details to the notification
                $notification->parsedDetails = $parsedNotification;
    
                return $notification;
            });
    
        } catch (\Exception $e) {
            \Log::error("Error fetching shopping cart notifications: " . $e->getMessage());
            return collect();
        }
    }
    

    public function markNotificationAsRead($notificationId)
    {
        try {
            $notification = Notification::find($notificationId);

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
            if (auth_user()) {
                $unreadCount = 0;

                if (auth_user()->buyer) {
                    $buyerId = auth_user()->id;

                    $userOrders = Order::where('buyer', $buyerId)->pluck('id');
                    $unreadOrderNotifications = OrderNotification::whereIn('order_', $userOrders)
                        ->whereHas('getNotification', fn($q) => $q->where('is_read', false))
                        ->count();

                    $userWishlists = Wishlist::where('buyer', $buyerId)->pluck('id');
                    $unreadWishlistNotifications = WishlistNotification::whereIn('wishlist', $userWishlists)
                        ->whereHas('getNotification', fn($q) => $q->where('is_read', false))
                        ->count();

                    $userShoppingCarts = ShoppingCart::where('buyer', $buyerId)->pluck('id');
                    $unreadShoppingCartNotifications = ShoppingCartNotification::whereIn('shopping_cart', $userShoppingCarts)
                        ->whereHas('getNotification', fn($q) => $q->where('is_read', false))
                        ->count();

                    $unreadCount = $unreadOrderNotifications + $unreadWishlistNotifications + $unreadShoppingCartNotifications;

                } elseif (auth_user()->seller) {
                    $sellerId = auth_user()->id;
                    $sellerGames = Game::where('owner', $sellerId)->pluck('id');

                    $unreadGameNotifications = GameNotification::whereIn('game', $sellerGames)
                        ->whereHas('getNotification', fn($q) => $q->where('is_read', false))
                        ->count();

                    $unreadCount = $unreadGameNotifications;
                }

                return response()->json(['unread_count' => $unreadCount], 200);
            }

            return response()->json(['unread_count' => 0], 200);
        } catch (\Exception $e) {
            \Log::error("Error fetching unread notifications count: " . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch unread notifications count'], 500);
        }
    }
    

    public function deleteNotification($notificationId)
    {
        try {
            $notification = Notification::find($notificationId);

            if (!$notification) {
                return response()->json(['error' => 'Notification not found'], 404);
            }

            $orderNotification = $notification->getOrderNotification;
            $wishlistNotification = $notification->getWishlistNotification;
            $shoppingCartNotification = $notification->getShoppingCartNotification;
            $gameNotification = $notification->getGameNotification;

            if ($orderNotification && $orderNotification->getOrder && $orderNotification->getOrder->buyer === auth()->id()) {
                $notification->delete();
                return response()->json(['message' => 'Order notification deleted successfully'], 200);

            } elseif ($wishlistNotification && $wishlistNotification->getWishlist && $wishlistNotification->getWishlist->buyer === auth()->id()) {
                $notification->delete();
                return response()->json(['message' => 'Wishlist notification deleted successfully'], 200);

            } elseif ($shoppingCartNotification && $shoppingCartNotification->getShoppingCart && $shoppingCartNotification->getShoppingCart->buyer === auth()->id()) {
                $notification->delete();
                return response()->json(['message' => 'Shopping cart notification deleted successfully'], 200);

            } elseif ($gameNotification && $gameNotification->getGame && $gameNotification->getGame->owner === auth()->id()) {
                $notification->delete();
                return response()->json(['message' => 'Game notification deleted successfully'], 200);

            }

            return response()->json(['error' => 'Unauthorized'], 403);
        } catch (\Exception $e) {
            \Log::error('Error deleting notification: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to delete notification'], 500);
        }
    }




    
    

}