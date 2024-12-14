<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $table = 'buyer';

    public $timestamps  = false;
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nif',
        'birth_date',
        'coins',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function reviewLikes()
    {
        return $this->hasMany(ReviewLike::class, 'author');
    }
}
