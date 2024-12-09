<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Game extends Model
{
    use HasFactory;

    protected $table = 'game';

    public $timestamps  = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'overall_rating',
        'positive_reviews',
        'negative_reviews',
        'owner',
        'is_active',
        'release_date',
        'age_id',
        'thumbnail_small_path',
        'thumbnail_large_path'
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'owner', 'id');
    }

    public function age()
    {
        return $this->belongsTo(Age::class);
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

    public function getThumbnailSmallPath() {
        return $this->thumbnail_small_path ?? 'images/thumbnail_small/default_thumbnail_small.jpg';
    }

    public function getThumbnailLargePath() {
        return $this->thumbnail_large_path ?? 'images/thumbnail_large/default_thumbnail_large.jpg';
    }

    public function images()
    {
        return $this->hasMany(GameMedia::class, 'game');
    }

    public function getReleaseDate()
    {
        if (is_null($this->release_date)) {
            return 'Not realeased yet';
        }

        return Carbon::parse($this->release_date)->format('d M, Y');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'game', 'id');
    }

    public function hasReviewedGame($user)
    {
        return $this->reviews()->where('author', $user->id)->exists();
    }

    public function hasReviews()
    {
        return $this->reviews()->exists();
    }

    public function updateRatings()
    {
        // count positive and negative reviews
        $this->positive_reviews = $this->reviews()->where('positive', true)->count();
        $this->negative_reviews = $this->reviews()->where('positive', false)->count();
        $totalReviews = $this->positive_reviews + $this->negative_reviews;
        $this->overall_rating = $totalReviews > 0 ? intval((100 * $this->positive_reviews) / $totalReviews) : 0;
    }
}