<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameLanguage extends Model
{
    use HasFactory;

    protected $table = 'gamelanguage';

    public $timestamps = false;

    public function game()
    {
        return $this->belongsTo(Game::class, 'game', 'id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language', 'id');
    }
}
