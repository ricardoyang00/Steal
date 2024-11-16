<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $table = 'seller';

    public $timestamps  = false;
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function getNameAttribute()
    {
        return $this->user->name ?? 'Unknown Seller';
    }
}
