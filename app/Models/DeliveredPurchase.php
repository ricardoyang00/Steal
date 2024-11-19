<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class DeliveredPurchase extends Model{
    use HasFactory;

    protected $table = 'delieveredPurchase';

    public $timestamps = false;

    protected $fillable = ['id', 'cdk'];

    public function cdk(){
        return $this->belongsTo(CDK::class, 'cdk', 'id');
    }

    public function purchase(){
        return $this->belongsTo(Purchase::Class, 'id', 'id');
    }

    public function value(){
        return $this->purchase->value ?? 0.0;
    }

}