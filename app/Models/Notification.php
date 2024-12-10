<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class Notification extends Model{
    use HasFactory;

    protected $table = 'notifications';

    public $timestamps = false;

    protected $fillable = ['id', 'title', 'description', 'time', 'is_read'];

    public function getWishlistNotification()
    {
        return $this->hasOne(WishlistNotification::class, 'id', 'id');
    }

    public function getShoppingCartNotification()
    {
        return $this->hasOne(ShoppingCartNotification::class, 'id', 'id');
    }

    public function getGameNotification()
    {
        return $this->hasOne(GameNotification::class, 'id', 'id');
    }

    public function getOrderNotification()
    {
        return $this->hasOne(OrderNotification::class, 'id', 'id');
    }

    public function getReviewNotification()
    {
        return $this->hasOne(ReviewNotification::class, 'id', 'id');
    }



}