<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'paymentmethod';

    public $timestamps = false;

    protected $fillable = ['name'];


    public function getPaymentMethods()
    {
        return $this->hasMany(Payment::Class, 'method', 'id');
    }



}