<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class WishlistNotification extends Model{
    use HasFactory;

    protected $table = 'notificationwishlist';

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'time', 'is_read' ,'wishlist'];

    public function getWishlist(){
        return $this->belongsTo(Wishlist::class, 'wishlist', 'id');
    }

}