<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Match extends Model
{
    protected $table = 'match';

    protected $fillable = [
        'season_id',
        'num',
        'stage',
        'status',
        'date',
        'start',
        'finish',
        'home_id',
        'guest_id',
        'audience',
        'home_participants',
        'guest_participants',
        'home_goals',
        'guest_goals',
        'win_main_time',
        'win_additional_time',
        'lose_main_time',
        'lose_additional_time'
    ];
}
