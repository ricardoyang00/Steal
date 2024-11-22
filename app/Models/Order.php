<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public $timestamps = false;

    protected $fillable = ['buyer', 'payment'];

    public function getBuyer()
    {
        return $this->belongsTo(Buyer::Class, 'buyer', 'id');
    }

    public function getPayment()
    {
        return $this->belongsTo(Payment::Class, 'payment', 'id');
    }

}