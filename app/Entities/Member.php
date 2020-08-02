<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'username', 'password', 'register_type', 'name', 'picture_url',
        'email', 'phone', 'gender', 'email_validated', 'email_notify',
        'app_notify', 'coupon', 'live_address', 'transport_address', 'points',
        'member_level', 'is_active'
    ];

    public function relatedOrder()
    {
        return $this->hasMany('App\Entities\Order', 'user_id', 'id');
    }

    public function relatedFeedback()
    {
        return $this->hasMany('App\Entities\Feedback', 'user_id', 'id');
    }
}
