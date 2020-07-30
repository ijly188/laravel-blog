<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'username', 'password', 'register_type', 'name', 'picturl_url',
        'email', 'phone', 'gender', 'email_validated', 'email_notify',
        'app_notify', 'coupon', 'live_address', 'transport_address', 'points',
        'member_level', 'is_active'
    ];
}
