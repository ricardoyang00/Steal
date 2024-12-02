<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Buyer;
use App\Models\Game;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlist';
    protected $fillable = ['buyer', 'game'];

    public $timestamps = false;

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
        return $this->belongsToMany(Game::class, 'wishlist', 'buyer', 'game');
    }
}
