<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $table = 'platform';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function gamePlatforms()
    {
        return $this->hasMany(GamePlatform::class, 'platform', 'id');
    }

    public function getNameAttribute()
    {
        return $this->name ?? 'Unknown Platform';
    }
}
