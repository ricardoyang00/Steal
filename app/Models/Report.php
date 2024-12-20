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
        return $this->belongsTo(Buyer::class, 'buyer_id');
    }
    
    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }
    
    public function reason()
    {
        return $this->belongsTo(Reason::class, 'reason_id');
    }    
}
