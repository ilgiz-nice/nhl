<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Player extends Model
{
    protected $fillable = [
        'friendly',
        'name',
        'current_team',
        'num',
        'height',
        'weight',
        'birthday',
        'role',
        'hand',
        'city',
        'past_teams',
        'photo'
    ];

    public function scopeStats($query) {
        $top_goals = DB::table('players')
            ->select('players.name AS name', 'players.id AS id',
                DB::raw('COUNT(a.id) as goals'),
                DB::raw('COUNT(a.id) as total'))
            ->leftJoin('goals as a', 'a.player_id', '=', 'players.friendly')
            ->groupBy('players.id')
            ->orderBy('total', 'DESC')
            ->orderBy('name')
            ->get();
        $top_assist = DB::table('players')
            ->select('players.name AS name', 'players.id AS id',
                DB::raw('COUNT(aa.player_assist_1_id) AS assist1'),
                DB::raw('COUNT(bb.player_assist_2_id) AS assist2'),
                DB::raw('COUNT(aa.player_assist_1_id) + COUNT(bb.player_assist_2_id) AS total'))
            ->leftJoin('goals AS aa', 'aa.player_assist_1_id', '=', 'players.friendly')
            ->leftJoin('goals AS bb', 'bb.player_assist_2_id', '=', 'players.friendly')
            ->groupBy('players.id')
            ->orderBy('total', 'DESC')
            ->orderBy('name')
            ->get();

        $array = array();
        $sort = array();
        $count = $query->count();

        for ($i=0;$i<$count;$i++) {
            if ($i>=5) {
                break;
            }
            $array['goal'][$i]['num'] = $i + 1;
            $array['goal'][$i]['id'] = $top_goals[$i]->id;
            $array['goal'][$i]['name'] = $top_goals[$i]->name;
            $array['goal'][$i]['goals'] = $top_goals[$i]->goals;
            $array['goal'][$i]['points'] = $top_goals[$i]->total;
        }

        for($i=0;$i<$count;$i++) {
            if ($i>=5) {
                break;
            }
            $array['assist'][$i]['num'] = $i + 1;
            $array['assist'][$i]['id'] = $top_assist[$i]->id;
            $array['assist'][$i]['name'] = $top_assist[$i]->name;
            $array['assist'][$i]['assist1'] = $top_assist[$i]->assist1;
            $array['assist'][$i]['assist2'] = $top_assist[$i]->assist2;
            $array['assist'][$i]['points'] = $top_assist[$i]->total;
        }

        for($i=0;$i<$count;$i++) {
            $sort['goal_assist'][$i]['num'] = $i + 1;
            $sort['goal_assist'][$i]['id'] = $top_goals[$i]->id;
            $sort['goal_assist'][$i]['name'] = $top_goals[$i]->name;
            $sort['goal_assist'][$i]['goals'] = $top_goals[$i]->goals;
            for ($d=0;$d<$count;$d++) {
                if ($top_goals[$i]->name == $top_assist[$d]->name) {
                    $sort['goal_assist'][$i]['assist1'] = $top_assist[$d]->assist1;
                    $sort['goal_assist'][$i]['assist2'] = $top_assist[$d]->assist2;
                    $sort['goal_assist'][$i]['points'] = $top_goals[$i]->total + $top_assist[$d]->total;
                }
            }
        }

        if (count($sort) > 0) {
            usort($sort['goal_assist'], function($a, $b) {
                return $b['points'] - $a['points'];
            });
        }

        for ($i=0;$i<$count;$i++) {
            if ($i>=5) {
                break;
            }
            $array['goal_assist'][$i] = $sort['goal_assist'][$i];
            $array['goal_assist'][$i]['num'] = $i + 1;
        }

        return $array;
    }
}
