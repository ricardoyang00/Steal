<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'game';

    public $timestamps  = false;

    protected $fillable = ['name', 'price'];

    public function shoppingCarts()
    {
        return $this->belongsToMany(ShoppingCart::class, 'ShoppingCartGame', 'game_id', 'shopping_cart_id');
    }
}