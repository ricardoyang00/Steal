<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class CanceledPurchase extends Model{
    use HasFactory;

    protected $table = 'canceledpurchase';

    public $timestamps = false;

    protected $fillable = ['id','game'];

    public function getGame(){
        return $this->belongsTo(Game::class, 'game', 'id');
    }

    public function getPurchase(){
        return $this->belongsTo(Purchase::Class, 'id', 'id');
    }

}