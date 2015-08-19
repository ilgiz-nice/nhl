<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'match_id',
        'team_id',
        'player_id',
        'player_goalkeeper_id',
        'player_assist_1_id',
        'player_assist_2_id',
        'time',
        'bullitt',
        'win_bullitt',
        'win_goal',
        'disparity',
        'win_composition',
        'lose_composition'
    ];
}
