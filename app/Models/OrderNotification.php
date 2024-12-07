<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class OrderNotification extends Model
{
    use HasFactory;

    protected $table = 'notificationorder';

    public $timestamps = false;

    protected $fillable = ['id', 'order_',];

    public function getNotification()
    {
        return $this->belongsTo(Notification::class, 'id', 'id');
    }

    public function getOrder(){
        return $this->belongsTo(Order::class, 'order_', 'id');
    }

}