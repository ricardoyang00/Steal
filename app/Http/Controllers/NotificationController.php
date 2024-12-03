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
        if (auth_user() && auth_user()->buyer) {
            return view('pages/notifications', 
                ['notifications' => $this->getNotifications()]
            );
        } else {
            return redirect()->route('login');
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
    
        // Sort notifications by time (most recent first)
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
            ->orderBy('time', 'desc')
            ->get();
    
            return $notifications;
        } catch (Exception $e) {
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
        // TODO
        return collect();
    }

    public function markAllAsRead(){
        try{
            $userOrders = Order::where('buyer', auth()->id())->pluck('id');
            OrderNotification::whereIn('order_', $userOrders)
                ->where('isRead', false)
                ->update(['isRead' => true]);
        }
        catch(Exception $e){
            \Log::error("Error in read notifications: " . $e->getMessage());
            return response()->json(['error' => 'Unable to mark notifications as read'], 500);
        }
    }

    public function getUnreadCount() {
        try {
            $userOrders = Order::where('buyer', auth()->id())->pluck('id');
            $unreadCount = OrderNotification::whereIn('order_', $userOrders)
                ->where('is_read', false)
                ->count();
    
            return response()->json(['unread_count' => $unreadCount], 200);
        } catch (\Exception $e) {
            \Log::error("Error fetching unread notifications count: " . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch unread notifications count'], 500);
        }
    }
    
    

}