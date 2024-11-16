<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $table = 'ShoppingCart';
    public $timestamps = false;

    protected $fillable = ['buyer', 'game'];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer', 'id');
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game', 'id');
    }
}