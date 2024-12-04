<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMedia extends Model
{
    use HasFactory;

    protected $table = 'gamemedia';

    public $timestamps = false;

    protected $fillable = [
        'path',
        'game',
        'order_'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
