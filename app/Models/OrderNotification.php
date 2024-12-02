<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class OrderNotifications extends Model
{
    use HasFactory;

    protected $table = 'notificationorder';

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'time', 'isRead' ,'order_',];

    public function getOrder(){
        return $this->belongsTo(Order::class, 'order_', 'id');
    }

    private function createOrderNotification($order, $purchasedItems, $canceledItems) {
        $title = 'Order Notification';
        $description = '';
    
        $orderDate = $order->created_at->format('F j, Y, g:i a');
    
        if (empty($purchasedItems) && !empty($canceledItems)) {
            $description = 'Your order from ' . $orderDate . ' could not be completed. ';
            $description .= 'Unfortunately, none of the items in your order were available due to insufficient stock.';
        } elseif (empty($canceledItems)) {
            $description = 'Your order from ' . $orderDate . ' was successfully completed. All items have been purchased.';
        } else {
            $description = 'Your order from ' . $orderDate . ' was partially completed. ';
            $description .= 'Unfortunately, the following items could not be purchased, due to insufficient stock: ';
            $canceledGameNames = array_column($canceledItems, 'gameName');
            $description .= implode(', ', $canceledGameNames) . '.';
        }
    
        OrderNotifications::create([
            'title' => $title,
            'description' => $description,
            'time' => now(),
            'isRead' => false,
            'order_' => $order->id,
        ]);
    }

}