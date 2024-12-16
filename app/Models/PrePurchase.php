<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class PrePurchase extends Model{
    use HasFactory;

    protected $table = 'prepurchase';

    public $timestamps = false;

    protected $fillable = ['id', 'game'];

    public function getId(){
        return $this->id;
    }

    public function getGame(){
        return $this->belongsTo(Game::class, 'game', 'id');
    }

    public function getPurchase(){
        return $this->belongsTo(Purchase::Class, 'id', 'id');
    }

    public function getValue(){
        return $this->purchase->value ?? 0.0;
    }

}