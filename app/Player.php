<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'name',
        'current',
        'height',
        'weight',
        'birthday',
        'role',
        'hand',
        'city',
        'past_teams',
        'photo'
    ];
}
