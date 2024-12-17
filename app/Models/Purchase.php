<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchase';

    public $timestamps = false;

    protected $fillable = ['order_', 'value'];

    public function getOrder(){
        return $this->belongsTo(Order::class, 'order_', 'id');
    }

    public function getValue(){
        return $this->value ?? 0.0;
    }

    public function getDeliveredPurchase()
    {
        return $this->hasOne(DeliveredPurchase::class, 'id', 'id');
    }

    public function getPrePurchase()
    {
        return $this->hasOne(PrePurchase::class, 'id', 'id');
    }

    public function getCanceledPurchase()
    {
        return $this->hasOne(CanceledPurchase::class, 'id', 'id');
    }


    public function type()
    {
        if (CanceledPurchase::where('id', $this->id)->exists()) {
            return 'CanceledPurchase';
        }

        if (DeliveredPurchase::where('id', $this->id)->exists()) {
            return 'DeliveredPurchase';
        }

        return 'Unknown';
}


}