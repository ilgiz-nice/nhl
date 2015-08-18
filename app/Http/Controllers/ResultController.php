<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Team;
use App\Match;

class ResultController extends Controller
{
    public function index() {
        $array = $this->results();

        return view('result.index', compact('array'));
    }

    public function results() {
        $array = array();
        $teams = Team::all()->toArray();
        $matches = Match::all();

        $count = count($teams);

        for ($i=0;$i<$count;$i++) {
            $array[$i]['id'] = $teams[$i]['id'];
            $array[$i]['name'] = $teams[$i]['name'];

            for ($d=0;$d<$count;$d++) {
                $array[$i]['inner'][$d]['id'] = $teams[$d]['id'];

                foreach ($matches as $match) {
                    if ($i == $d) {
                        $array[$i]['inner'][$d]['score'] = '***';
                        continue;
                    }
                    if ($match->home_id == $array[$i]['id'] AND $match->guest_id == $array[$i]['inner'][$d]['id']) {
                        $array[$i]['inner'][$d]['score'] = $match->home_goals . ' - ' . $match->guest_goals;
                        break;
                    }
                    else  {
                        $array[$i]['inner'][$d]['score'] = '0 - 0';
                    }
                }
            }
        }

        return $array;
    }
}
