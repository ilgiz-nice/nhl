<?php

namespace App\Http\Controllers;

use App\Match;
use App\Goal;
use App\Team;
use App\Season;
use App\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Excel;

class ManagerController extends Controller
{
    public function index() {
        $teams = Team::Select();
        $matches = Match::Export()->get();
        return view('manager/index', compact('teams', 'matches'));
    }
}