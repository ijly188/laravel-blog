<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SystemUser extends Model
{
    protected $fillable = [
        'eip_member_id', 'username', 'password', 'group',
        'main_menu_id', 'sub_menu_id', 'functions', 'is_active'
    ];
}
