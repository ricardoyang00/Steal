<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';

    public $timestamps = false;

    protected $fillable = ['method', 'value'];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::Class, 'method', 'id');
    }

    public function order()
    {
        return $this->hasOne(Order::Class, 'payment', 'id');
    }

    public function value()
    {
        return $this->value ?? 0;
    }

}