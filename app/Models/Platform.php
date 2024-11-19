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

    public function games()
    {
        return $this->belongsToMany(Game::class, 'gameplatform', 'platform', 'game');
    }
}
