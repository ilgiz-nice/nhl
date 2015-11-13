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
use App\News;

class ManagerController extends Controller
{
    public function index() {
        $num = Match::orderBy('num', 'DESC')->first();
        $num = $num->num + 1;
        $teams = Team::Select();
        $matches = Match::Export()->get();
        $news = News::all();
        return view('manager/index', compact('teams', 'matches', 'news', 'num'));
    }
}