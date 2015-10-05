<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'short',
        'description',
        'coach_id',
        'logo',
        'photo',
        'city'
    ];

    public function scopeSelect($query) {
        $array = [];
        foreach ($query->get() as $t) {
            $array[$t->id] = $t->name;
        }
        return $array;
    }

    public function scopeTournament($query) {
        $output = array();

        foreach ($query->get() as $team) {
            $inner = array();
            $inner['id'] = $team->id;
            $inner['name'] = $team->name;
            $inner['games'] = 0;
            $inner['wins'] = 0;
            $inner['wins_overtime'] = 0;
            $inner['wins_bullitt'] = 0;
            $inner['loses_bullitt'] = 0;
            $inner['loses_overtime'] = 0;
            $inner['loses'] = 0;
            $inner['goals'] = '0 - 0';
            $inner['points'] = 0;
            $output[] = $inner;
        }

        return $output;
    }
}
