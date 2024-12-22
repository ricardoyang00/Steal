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
use App\Models\ReviewNotification;
use App\Models\PrePurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
    
    public function createOrderNotification($order, $prePurchasedItems, $purchasedItems, $canceledItems) {
        $title = 'Order Processed';
        $description = '';
    
        if (empty($purchasedItems) && empty($prePurchasedItems) && !empty($canceledItems)) {
            $description = 'Your order could not be completed. ';
            $description .= 'Unfortunately, none of the items in your order were available due to insufficient stock.';
        } elseif (empty($canceledItems)) {
            $description = 'Your order was successfully completed. All items have been purchased.';
        } else {
            $description = 'Your order was partially completed. ';
            $description .= 'Unfortunately, some items could not be purchased, due to insufficient stock. ';
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
            $gameId = $game->id;
            $gameName = $game->name;
    
            // Fetch related wishlists
            $wishlists = DB::table('wishlist')
                ->where('game', $game->id)
                ->pluck('id');
    
            foreach ($wishlists as $wishlist) {
                $notification = Notification::create([
                    'title' => "Wishlist Game Price Update",
                    'description' => "A game on your wishlist had its price updated. Game Id: {$gameId}, Game Name: {$gameName}, Old Price: $ {$oldPrice}, New Price: $ {$newPrice}, Type: Price",
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
                    'description' => "A game on your shopping cart had its price updated. Game Id: {$gameId}, Game Name: {$gameName}, Old Price: $ {$oldPrice}, New Price: $ {$newPrice}, Type: Price",
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
    

    public function createStockNotifications($game, $soldOut) {
        try {
            $wishlists = DB::table('wishlist')
                ->where('game', $game->id)
                ->pluck('id');
    
            if($soldOut === 'sold_out'){
                $description = "{$game->name} has just sold out. Type: Stock";
            }
            elseif($soldOut === 'available'){
                $description = "Good news! {$game->name} is now available for purchase! Type: Stock";
            }
    
            foreach ($wishlists as $wishlist) {
                $notification = Notification::create([
                    'title' => "Stock Update on Wishlist",
                    'description' => $description,
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
    
    
            foreach ($shoppingCarts as $shoopingCart) {
                $notification = Notification::create([
                    'title' => "Stock Update on Shopping Cart",
                    'description' => $description,
                    'time' => now(),
                    'is_read' => false,
                ]);
                ShoppingCartNotification::create([
                    'id' => $notification->id,
                    'shopping_cart' => $shoopingCart,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Error creating stock wishlist notifications: " . $e->getMessage());
        }
    }

    public function createGameNotifications($prePurchasedItems, $purchasedItems) {
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
                $gamePurchases[$gameId]['type'] = 'Delivered';
            }

            foreach ($prePurchasedItems as $item) {
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
                $gamePurchases[$gameId]['type'] = 'Ordered';
            }
    
            foreach ($gamePurchases as $data) {
                $game = $data['game'];
                $quantity = $data['quantity'];
                $totalValue = $data['totalValue'];
                $type = $data['type'];

                if($type === 'Delivered'){
                    $title = "Game Sold";
                    $description = "One of your games has been purchased. GameName: {$game->name}, quantity: {$quantity}, totalPrice: {$totalValue}";
                }
                elseif($type === 'Ordered'){
                    $title = "Game Ordered";
                    $description = "One of your games has been ordered. GameName: {$game->name}, quantity: {$quantity}, totalPrice: {$totalValue}";
                }
    
                $notification = Notification::create([
                    'title' => $title,
                    'description' => $description,
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
            $gameId = $review->getGame->id;
            $gameName = $review->getGame->name;
            $reviewType = $review->is_positive ? 'Positive' : 'Negative';
    
            $notification = Notification::create([
                'title' => "Game Reviewed",
                'description' => "One of your games has been reviewed. Review Author: {$reviewAuthor}, Reviewed Game Id: {$gameId}, Reviewed Game: {$gameName}, reviewType: {$reviewType}",
                'time' => now(),
                'is_read' => false,
            ]);
    
            // Create the specialized notification linking to the review
            ReviewNotification::create([
                'id' => $notification->id,
                'review' => $review->id,
            ]);
        } catch (\Exception $e) {
            \Log::error("Error creating review notification: " . $e->getMessage());
        }
    }

    public function createOrderStatusChangeNotification($game, $quantity)
    {
        $title = 'Order Status Updated';
        $description = "One of your ordered items has been delivered. Game: {$game->name}, Quantity:{$quantity}";

        try {
            // Start a database transaction
            DB::beginTransaction();

            // 1. Fetch PrePurchases linked to the game, sorted by time ascending, limited by quantity
            $prePurchases = PrePurchase::where('game', $game->id)
            ->whereHas('getPurchase.getOrder')
            ->with(['getPurchase.getOrder']) // Eager load the Order relationship
            ->join('purchase', 'prepurchase.id', '=', 'purchase.id')
            ->join('orders', 'purchase.order_', '=', 'orders.id')
            ->orderBy('orders.time', 'asc') // Sort by Order's time attribute
            ->select('prepurchase.*') 
            ->take($quantity)
            ->get();

            if ($prePurchases->isEmpty()) {
                Log::info("No PrePurchases found for Game ID: {$game->id}");
                DB::rollBack();
                return;
            }

            $orderIds = $prePurchases->pluck('getPurchase.getOrder.id')->unique();

            if ($orderIds->isEmpty()) {
                Log::info("No associated Orders found for the selected PrePurchases.");
                DB::rollBack();
                return;
            }

            // 3. Fetch Orders along with their Buyers
            $orders = Order::whereIn('id', $orderIds)
                ->with('getBuyer')
                ->get();

            if ($orders->isEmpty()) {
                Log::info("No Orders found for Order IDs: " . implode(', ', $orderIds->toArray()));
                DB::rollBack();
                return;
            }

            foreach ($orders as $order) {
                $buyer = $order->buyer;

                if (!$buyer) {
                    Log::warning("Order ID {$order->id} has no associated Buyer.");
                    continue;
                }

                // Create the base notification
                $notification = Notification::create([
                    'title' => $title,
                    'description' => $description,
                    'time' => now(),
                    'is_read' => false,
                ]);

                OrderNotification::create([
                    'id' => $notification->id, // Assuming 'id' is the primary key in Notification and a foreign key in OrderNotification
                    'order_' => $order->id,
                ]);
            }

            DB::commit();

            Log::info("Order status change notifications created successfully for Game ID: {$game->id}");

        } catch (\Exception $e) {
            // Rollback the transaction in case of errors
            DB::rollBack();

            // Log the error for debugging purposes
            Log::error("Error creating order status change notifications: " . $e->getMessage());

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
        $perPage = 8; // Number of notifications per page
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
                'getOrder.getPurchases.getCanceledPurchase.getGame',
                'getOrder.getPurchases.getPrePurchase.getGame'
            ])
            ->get();
    
            // Sort by notification time descending
            $notifications = $notifications->sortByDesc(fn($notification) => $notification->getNotification->time)->values();
    
            return $notifications->map(function ($notification) {
                $notification->title = $notification->getNotification->title;
                $notification->description = $notification->getNotification->description;
                $notification->time = $notification->getNotification->time;
                $notification->is_read = $notification->getNotification->is_read;
    
                $notification->type = 'Order Completed';

                if ($notification->title === 'Order Status Updated') {
                    // Set type to 'Status Change'
                    $notification->type = 'Status Change';
    
    
                    // Use regex to parse 'GameName' and 'Quantity' from the description
                    $pattern = '/Game:\s*(.+?),\s*Quantity:\s*(\d+)/';
                    if (preg_match($pattern, $notification->description, $matches)) {
                        // Extracted values
                        $gameName = $matches[1];
                        $quantity = (int)$matches[2];
    
                        // Add parsed attributes to the notification
                        $notification->gameName = $gameName;
                        $notification->quantity = $quantity;
    
                        // Remove the parsed part from the description
                        $notification->description = preg_replace($pattern, '', $notification->description);
                    }
                }
    
                $order = $notification->getOrder;
                if ($order) {
                    $formattedOrderDate = (new \DateTime($order->time))->format('F d, Y H:i');
                    $purchases = $order->getPurchases;
    
                    $details = $purchases->map(function ($purchase) {
                        if ($purchase->getDeliveredPurchase) {
                            $game = $purchase->getDeliveredPurchase->getCDK->getGame ?? null;
                            return [
                                'type' => 'Delivered',
                                'gameId' => $game->id,
                                'gameName' => $game->name ?? 'Unknown Game',
                                'value' => $purchase->getValue(),
                            ];
                        } elseif ($purchase->getCanceledPurchase) {
                            $game = $purchase->getCanceledPurchase->getGame ?? null;
                            return [
                                'type' => 'Canceled',
                                'gameId' => $game->id,
                                'gameName' => $game->name ?? 'Unknown Game',
                                'value' => $purchase->getValue(),
                            ];
                        }
                        elseif ($purchase->getPrePurchase) {
                            $game = $purchase->getPrePurchase->getGame ?? null;
                            return [
                                'type' => 'Ordered',
                                'gameId' => $game->id,
                                'gameName' => $game->name ?? 'Unknown Game',
                                'value' => $purchase->getValue(),
                            ];
                        }
                        return null;
                    })->filter();
    
                    $notification->orderDetails = [
                        'date' => $formattedOrderDate,
                        'purchases' => $details->toArray(),
                        'totalPrice' => $order->getPayment->value,
                        'coinsUsed' => $order->coins,
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
    
            $notifications = ReviewNotification::whereHas('getReview.getGame', function ($query) use ($sellerId) {
                $query->where('owner', $sellerId);
            })
            ->with(['getNotification', 'getReview.getGame', 'getReview.getAuthor'])
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
    
                if (preg_match('/Review Author:\s?([^,]+),\s?Reviewed Game Id:\s?([^,]+),\s?Reviewed Game:\s?([^,]+),\s?reviewType:\s?([^,]+)/', $desc, $matches)) {
                    $parsedNotification['review_author'] = $matches[1] ?? null;
                    $parsedNotification['game_id'] = $matches[2] ?? null;
                    $parsedNotification['game_name'] = $matches[3] ?? null;
                    $parsedNotification['review_type'] = $matches[4] ?? null;
    
                    // Remove the parsed details from the description
                    $desc = preg_replace('/Review Author:\s?[^,]+,\s?Reviewed Game Id:\s?([^,]+),\s?Reviewed Game:\s?[^,]+,\s?reviewType:\s?(Positive|Negative)/', '', $desc);
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
                $notification->type = 'Game';
    
                $gameId = $notification->getGame->id;
                $title = $notification->getNotification->title;
                $desc = $notification->getNotification->description;
                $time = $notification->getNotification->time;
                $isRead = $notification->getNotification->is_read;
    
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
    
                $notification->gameId = $gameId;
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
    
                if (preg_match("/Game Id: (\d+), Game Name: ([^,]+)/", $desc, $matches)) {
                    $parsedNotification['game_id'] = $matches[1] ?? null;
                    $parsedNotification['game_name'] = $matches[2] ?? null;
                }
    
                if (strpos($desc, 'Type: Price') !== false) {
                    $matches = [];
                    if (preg_match('/Old Price: \$\s?(\d+(?:\.\d{1,2})?), New Price: \$\s?(\d+(?:\.\d{1,2})?)/', $desc, $matches)) {
                        $parsedNotification['specific_type'] = 'Price';
                        $parsedNotification['old_price'] = $matches[1] ?? null;
                        $parsedNotification['new_price'] = $matches[2] ?? null;
                    }
    
                    // Remove the price details from the description
                    $desc = preg_replace('/Game Id: \d+, Game Name: ?\'?[^,]+\'?, Old Price: \$\s?\d+(?:\.\d{1,2})?, New Price: \$\s?\d+(?:\.\d{1,2})?, Type: Price/', '', $desc);
                    $desc = trim($desc);
                    $notification->description = $desc;
    
                } elseif (strpos($desc, 'Type: Stock') !== false) {
                    $parsedNotification['specific_type'] = 'Stock';
                    $desc = preg_replace('/Type:\s*([^.]*)\.?$/i', '', $desc);
                    $desc = trim($desc);
                    $notification->description = $desc;
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
    
                if (preg_match("/Game Id: (\d+), Game Name: ([^,]+)/", $desc, $matches)) {
                    $parsedNotification['game_id'] = $matches[1] ?? null;
                    $parsedNotification['game_name'] = $matches[2] ?? null;
                }
    
                if (strpos($desc, 'Type: Price') !== false) {
                    $matches = [];
                    if (preg_match('/Old Price: \$\s?(\d+(?:\.\d{1,2})?), New Price: \$\s?(\d+(?:\.\d{1,2})?)/', $desc, $matches)) {
                        $parsedNotification['specific_type'] = 'Price';
                        $parsedNotification['old_price'] = $matches[1] ?? null;
                        $parsedNotification['new_price'] = $matches[2] ?? null;
                    }
    
                    $desc = preg_replace('/Game Id: \d+, Game Name: ?\'?[^,]+\'?, Old Price: \$\s?\d+(?:\.\d{1,2})?, New Price: \$\s?\d+(?:\.\d{1,2})?, Type: Price/', '', $desc);
                    $desc = trim($desc);
                    $notification->description = $desc;
    
                } elseif (strpos($desc, 'Type: Stock') !== false) {
                    $parsedNotification['specific_type'] = 'Stock';
                    $desc = preg_replace('/Type:\s*([^.]*)\.?$/i', '', $desc);
                    $desc = trim($desc);
                    $notification->description = $desc;
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
    
                    // Buyers do not see review notifications (assuming only sellers see them)
                    $unreadCount = $unreadOrderNotifications + $unreadWishlistNotifications + $unreadShoppingCartNotifications;
    
                } elseif (auth_user()->seller) {
                    $sellerId = auth_user()->id;
                    $sellerGames = Game::where('owner', $sellerId)->pluck('id');
    
                    $unreadGameNotifications = GameNotification::whereIn('game', $sellerGames)
                        ->whereHas('getNotification', fn($q) => $q->where('is_read', false))
                        ->count();
    
                    $unreadReviewNotifications = ReviewNotification::whereHas('getReview.getGame', function ($query) use ($sellerId) {
                        $query->where('owner', $sellerId);
                    })
                    ->whereHas('getNotification', fn($q) => $q->where('is_read', false))
                    ->count();
    
                    $unreadCount = $unreadGameNotifications + $unreadReviewNotifications;
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
        $reviewNotification = $notification->getReviewNotification;

        $userId = auth_user()->id;

        if ($orderNotification && $orderNotification->getOrder && $orderNotification->getOrder->buyer === $userId) {
            $notification->delete();
            return response()->json(['message' => 'Order notification deleted successfully'], 200);

        } elseif ($wishlistNotification && $wishlistNotification->getWishlist && $wishlistNotification->getWishlist->buyer === $userId) {
            $notification->delete();
            return response()->json(['message' => 'Wishlist notification deleted successfully'], 200);

        } elseif ($shoppingCartNotification && $shoppingCartNotification->getShoppingCart && $shoppingCartNotification->getShoppingCart->buyer === $userId) {
            $notification->delete();
            return response()->json(['message' => 'Shopping cart notification deleted successfully'], 200);

        } elseif ($gameNotification && $gameNotification->getGame && $gameNotification->getGame->owner === $userId) {
            $notification->delete();
            return response()->json(['message' => 'Game notification deleted successfully'], 200);

        } elseif ($reviewNotification && $reviewNotification->getReview && $reviewNotification->getReview->getGame && $reviewNotification->getReview->getGame->owner === $userId) {
            $notification->delete();
            return response()->json(['message' => 'Review notification deleted successfully'], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    } catch (\Exception $e) {
        \Log::error('Error deleting notification: ' . $e->getMessage());
        return response()->json(['error' => 'Unable to delete notification'], 500);
    }
}





    
    

}