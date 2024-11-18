<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePlatform extends Model
{
    use HasFactory;

    protected $table = 'gameplatform';

    public $timestamps = false;

    public function game()
    {
        return $this->belongsTo(Game::class, 'game', 'id');
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform', 'id');
    }
}
