<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CDK extends Model{
    use HasFactory;

    protected $table = 'cdk';

    public $timestamps  = false;

    protected $fillable = [
        'code',
        'game',
    ];

    public function getCode()
    {
        return $this->code;
    }

    public function getGame()
    {
        return $this->belongsTo(Game::class, 'game', 'id');
    }
}