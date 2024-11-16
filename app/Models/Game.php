<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'game';

    public $timestamps  = false;

    protected $fillable = [
        'name',
        'description',
        'minimum_age',
        'price',
        'overall_rating',
        'owner',
        'is_active',
        'release_date'
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'owner', 'id');
    }
}
