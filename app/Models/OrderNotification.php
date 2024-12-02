<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class OrderNotifications extends Model
{
    use HasFactory;

    protected $table = 'notificationorder';

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'time', 'isRead' ,'order_',];

    public function getOrder(){
        return $this->belongsTo(Order::class, 'order_', 'id');
    }

}