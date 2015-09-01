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
<<<<<<< HEAD

    public function scopeExist($query, $id, $time) {
        $query->where('match_id', '=', $id)->where('time', '=', $time);
    }

    public function scopeUpdateGoals($query, $id, $time) {
        $query->where('match_id', '=', $id)->where('time', '=', $time);
    }
=======
>>>>>>> f3ebb7fae61eb54b7013985d422aa4ddc691a024
}
