<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $table = 'player';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function gamePlayers()
    {
        return $this->hasMany(GamePlayer::class, 'player', 'id');
    }

    public function getNameAttribute()
    {
        return $this->name ?? 'Unknown Player';
    }
}
