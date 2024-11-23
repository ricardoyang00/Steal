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

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'gameplatform', 'game', 'platform');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'gamecategory', 'game', 'category');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'gamelanguage', 'game', 'language');
    }

    public function players()
    {
        return $this->belongsToMany(Player::class, 'gameplayer', 'game', 'player');
    }

    public function getCDKs()
    {
        return $this->hasMany(CDK::class, 'game', 'id');
    }

    public function getAvailableCDKs()
    {
        return $this->getCDKs()
            ->whereNotIn('id', DeliveredPurchase::pluck('cdk'))
            ->get();
    }

    public function deliveredPurchases()
    {
        return $this->hasManyThrough(DeliveredPurchase::class, CDK::class, 'game', 'cdk', 'id', 'id');
    }

    public function countDeliveredPurchases()
    {
        return DeliveredPurchase::whereIn('cdk', $this->getCDKs()->pluck('id'))->count();
    }
}