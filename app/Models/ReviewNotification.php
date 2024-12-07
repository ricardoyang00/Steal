<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class ReviewNotification extends Model
{
    use HasFactory;

    protected $table = 'notificationreview';

    public $timestamps = false;

    protected $fillable = ['id', 'review',];

    public function getNotification()
    {
        return $this->belongsTo(Notification::class, 'id', 'id');
    }

    public function getReview(){
        return $this->belongsTo(Review::class, 'review', 'id');
    }

}