<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    use HasFactory;

    protected $table = 'age';

    protected $fillable = 
    [
        'minimum_age',
        'name',
        'description',
        'image_path'
    ];

    public $timestamps  = false;

    public function game()
    {
        return $this->hasOne(Game::class, 'age_id', 'id');
    }
}
