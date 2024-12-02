<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class OrderNotification extends Model
{
    use HasFactory;

    protected $table = 'notificationorder';

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'time', 'is_read' ,'order_',];

    public function getOrder(){
        return $this->belongsTo(Order::class, 'order_', 'id');
    }

    public function createOrderNotification($order, $purchasedItems, $canceledItems) {
        $title = 'Order Notification';
        $description = '';
        $orderTime = $order->time; // Assuming $order->time contains the date value
        $formattedOrderTime = new \DateTime($orderTime);
        $formattedOrderTime = $formattedOrderTime->format('d F Y');
    
        if (empty($purchasedItems) && !empty($canceledItems)) {
            $description = 'Your order from ' . $formattedOrderTime . ' could not be completed. ';
            $description .= 'Unfortunately, none of the items in your order were available due to insufficient stock.';
        } elseif (empty($canceledItems)) {
            $description = 'Your order from ' . $formattedOrderTime . ' was successfully completed. All items have been purchased.';
        } else {
            $description = 'Your order from ' . $formattedOrderTime . ' was partially completed. ';
            $description .= 'Unfortunately, the following items could not be purchased, due to insufficient stock: ';
            $canceledGameNames = array_column($canceledItems, 'gameName');
            $description .= implode(', ', $canceledGameNames) . '.';
        }
    
        self::create([
            'title' => $title,
            'description' => $description,
            'order_' => $order->id,
        ]);
    }

}