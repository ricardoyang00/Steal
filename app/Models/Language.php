<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $table = 'language';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'gamelanguage', 'language', 'game');
    }
}
