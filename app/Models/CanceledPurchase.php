<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class CanceledPurchase extends Model{
    use HasFactory;

    protected $table = 'canceledPurchase';

    public $timestamps = false;

    protected $fillable = ['id','game'];

    public function game(){
        return $this->belongsTo(Game::class, 'game', 'id');
    }

    public function purchase(){
        return $this->belongsTo(Purchase::Class, 'id', 'id');
    }

}