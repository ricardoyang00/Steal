<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class Notification extends Model{
    use HasFactory;

    protected $table = 'notification';

    public $timestamps = false;

    protected $fillable = ['id', 'title', 'description', 'time', 'is_read'];

    public function wishlistNotification()
    {
        return $this->hasOne(NotificationWishlist::class, 'id', 'id');
    }

    public function shoppingCartNotification()
    {
        return $this->hasOne(NotificationShoppingCart::class, 'id', 'id');
    }

    public function gameNotification()
    {
        return $this->hasOne(NotificationGame::class, 'id', 'id');
    }

    public function orderNotification()
    {
        return $this->hasOne(NotificationOrder::class, 'id', 'id');
    }

    public function reviewNotification()
    {
        return $this->hasOne(NotificationReview::class, 'id', 'id');
    }



}