<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class GameNotification extends Model{
    use HasFactory;

    protected $table = 'notificationgame';

    public $timestamps = false;

    protected $fillable = ['id' ,'game'];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'id', 'id');
    }

    public function getGame(){
        return $this->belongsTo(Game::class, 'game', 'id');
    }

}