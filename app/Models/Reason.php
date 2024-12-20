<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'description',
    ];

    protected $table = 'reason';

    public function reports()
    {
        return $this->hasMany(Report::class, 'reason');
    }
}
