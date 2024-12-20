<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'report';

    public $timestamps = false;

    protected $fillable = [
        'buyer',
        'review',
        'reason',
        'description',
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer');
    }
    
    public function review()
    {
        return $this->belongsTo(Review::class, 'review');
    }
    
    public function reason()
    {
        return $this->belongsTo(Reason::class, 'reason');
    }    
}
