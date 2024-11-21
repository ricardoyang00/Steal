<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class DeliveredPurchase extends Model{
    use HasFactory;

    protected $table = 'deliveredpurchase';

    public $timestamps = false;

    protected $fillable = ['id', 'cdk'];

    public function getCdk(){
        return $this->belongsTo(CDK::class, 'cdk', 'id');
    }

    public function getPurchase(){
        return $this->belongsTo(Purchase::Class, 'id', 'id');
    }

    public function getValue(){
        return $this->purchase->value ?? 0.0;
    }

}