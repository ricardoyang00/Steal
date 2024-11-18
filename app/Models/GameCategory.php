<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCategory extends Model
{
    use HasFactory;

    protected $table = 'gamecategory';

    public $timestamps = false;

    public function game()
    {
        return $this->belongsTo(Game::class, 'game', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }
}
