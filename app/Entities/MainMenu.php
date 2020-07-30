<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class MainMenu extends Model
{
    protected $fillable = [
        'name', 'icon', 'route', 'sort',
        'functions', 'is_active'
    ];
}
