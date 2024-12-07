<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class OrderNotification extends Model
{
    use HasFactory;

    protected $table = 'notificationorder';

    public $timestamps = false;

    protected $fillable = ['id', 'order_',];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'id', 'id');
    }

    public function getOrder(){
        return $this->belongsTo(Order::class, 'order_', 'id');
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
    
        self::create([
            'title' => $title,
            'description' => $description,
            'order_' => $order->id,
        ]);
    }

}