<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function isSold()
    {
        return DB::table('deliveredpurchase')
            ->where('cdk', $this->id)
            ->exists();
    }

    public function deliveredPurchase()
    {
        return $this->hasOne(DeliveredPurchase::class, 'cdk', 'id');
    }
}