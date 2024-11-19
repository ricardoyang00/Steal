<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CDK extends Model{
    use HasFactory;

    protected $table = 'cdk';

    public $timestamps  = false;

    public function game()
    {
        return $this->belongsTo(Game::class, 'game', 'id');
    }


}