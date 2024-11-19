<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'game';

    public $timestamps  = false;

    protected $fillable = [
        'name',
        'description',
        'minimum_age',
        'price',
        'overall_rating',
        'owner',
        'is_active',
        'release_date'
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'owner', 'id');
    }

    public function shoppingCarts()
    {
        return $this->belongsToMany(ShoppingCart::class, 'ShoppingCartGame', 'game_id', 'shopping_cart_id');
    }

    public function gamePlatforms()
    {
        return $this->hasMany(GamePlatform::class, 'game', 'id');
    }

    public function gameCategories()
    {
        return $this->hasMany(GameCategory::class, 'game', 'id');
    }

    public function gameLanguages()
    {
        return $this->hasMany(GameLanguage::class, 'game', 'id');
    }

    public function gamePlayers()
    {
        return $this->hasMany(GamePlayer::class, 'game', 'id');
    }

    public function CDKs()
    {
        return $this->hasMany(CDK::class, 'game', 'id');
    }

    public function availableCDKs()
    {
        return $this->CDKs()
            ->whereNotIn('id', DeliveredPurchase::pluck('cdk'))
            ->get();
    }
}