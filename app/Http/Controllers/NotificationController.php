<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    
        usort($notifications, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
    
        return $notifications;
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

}