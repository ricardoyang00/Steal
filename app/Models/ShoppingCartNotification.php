<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class ShoppingCartNotification extends Model{
    use HasFactory;

    protected $table = 'notificationshoppingcart';

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'time', 'is_read' ,'shopping_cart'];

    public function getShoppingCart(){
        return $this->belongsTo(ShoppingCart::class, 'shopping_cart', 'id');
    }

}