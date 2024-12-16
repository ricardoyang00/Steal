<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'game',
        'description',
    ];

    protected $table = 'review';

    public $timestamps = false;

    public function getAuthor() 
    {
        return $this->belongsTo(Buyer::class, 'author', 'id');
    }

    public function getGame() 
    {
        return $this->belongsTo(Game::class, 'game', 'id');
    }

    public function likes() {
        return $this->hasMany(ReviewLike::class, 'review');
    }

    public function likesCount()
    {
        return $this->likes()->count();
    }
}
