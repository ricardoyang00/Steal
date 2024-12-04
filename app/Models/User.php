<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Order;
use App\Models\Buyer;
use Illuminate\Support\Facades\DB;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'is_active',
        'is_blocked',
        'google_id',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function buyer()
    {
        return $this->hasOne(Buyer::class, 'id', 'id');
    }

    public function seller()
    {
        return $this->hasOne(Seller::class, 'id', 'id');
    }

    public function hasDeliveredPurchase($gameId)
    {
        return DB::table('purchase')
            ->join('orders', 'purchase.order_', '=', 'orders.id')
            ->join('deliveredpurchase', 'purchase.id', '=', 'deliveredpurchase.id')
            ->join('cdk', 'deliveredpurchase.cdk', '=', 'cdk.id')
            ->where('cdk.game', $gameId)
            ->where('orders.buyer', $this->id)
            ->exists();
    }

}
