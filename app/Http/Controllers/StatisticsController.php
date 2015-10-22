<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Match;

class StatisticsController extends Controller
{
    public function index() {
        $tournament = Match::Summary();
        $tournament = $tournament[0]->total;
        //dd($tournament);

        return view('stats.index', compact('tournament'));
    }
}
