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

    public function games()
    {
        return $this->belongsToMany(Game::class, 'gameplayer', 'player', 'game');
    }
}
