<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewLike extends Model
{
    protected $fillable = [
        'review',
        'author',
    ];

    protected $table = 'reviewlike';

    public $timestamps = false;

    public function review()
    {
        return $this->belongsTo(Review::class, 'review');
    }

    public function author()
    {
        return $this->belongsTo(Buyer::class, 'author');
    }
}
