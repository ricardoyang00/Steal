<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePlayer extends Model
{
    use HasFactory;

    protected $table = 'gameplayer';

    public $timestamps = false;

    public function game()
    {
        return $this->belongsTo(Game::class, 'game', 'id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'player', 'id');
    }
}
