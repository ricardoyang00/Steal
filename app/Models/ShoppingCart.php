<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $table = 'shoppingcart'; // Use lowercase table name to avoid case sensitivity issues

    public $timestamps = false;

    protected $fillable = ['quantity', 'buyer', 'game'];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer');
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game');
    }

    public function games()
    {
        return $this->belongsToMany(Game::class, 'shoppingcart', 'buyer', 'game')
                    ->withPivot('quantity');
    }
}