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

    private function getNotifications(){
        return [
            'orderNotifications' => $this->getOrderNotifications(),
            'reviewNotifications' => $this->getReviewNotifications(),
            'gameNotifications' => $this->getGameNotifications(),
            'wishlistNotifications' => $this->getWishlistNotifications(),
        ];
    }

    private function getOrderNotifications() {
        try {
            $buyerId = auth_user()->id;
    
            $notifications = OrderNotifications::whereHas('getOrder', function ($query) use ($buyerId) {
                $query->where('buyer', $buyerId);
            })
            ->orderBy('time', 'desc')
            ->get();
    
            return $notifications;
        } catch (Exception $e) {
            \Log::error("Error fetching order notifications: " . $e->getMessage());
            return [];
        }
    }
    

    private function getReviewNotifications() {
        // TODO
        return [];
    }

    private function getGameNotifications() {
        // TODO
        return [];
    }

    private function getWishlistNotifications() {
        // TODO
        return [];
    }

}