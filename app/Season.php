<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'season',
        'participants',
        'placement',
        'active'
    ];
}
