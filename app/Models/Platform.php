<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $table = 'platform';

    public $timestamps = false;

    public function gamePlatforms()
    {
        return $this->hasMany(GamePlatform::class, 'platform', 'id');
    }
}
