<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'passwordreset';

    public $timestamps  = false;

    protected $primaryKey = 'email';

    public $incrementing = false;

    protected $fillable = [
        'email', 
        'token', 
        'created_at'
    ];
}