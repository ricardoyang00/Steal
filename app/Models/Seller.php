<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $table = 'seller';

    protected $primaryKey = 'id';

    public $timestamps  = false;
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
