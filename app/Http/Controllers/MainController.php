<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Team;
use App\Match;
use App\Goal;
use App\Player;
use App\News;

class MainController extends Controller
{
    public function index() {
        $games = Match::Played()->get();
        $tournament_teams = Team::Tournament();
        $tournament = Match::Tournament($tournament_teams);
        $news = News::Latest()->get();
        $stats = Player::Stats();
        $calendar = Match::NotPlayed();
        return view('main.index', compact('games', 'tournament', 'news', 'stats', 'calendar'));
    }
}
