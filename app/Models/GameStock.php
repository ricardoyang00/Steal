<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class GameStock extends Model
{
    use HasFactory;

    protected $table = 'gamestock';

    public $timestamps = false;

    protected $fillable = ['game', 'quantity'];

    public function getGame()
    {
        return $this->belongsTo(Game::Class, 'game', 'id');
    }

}