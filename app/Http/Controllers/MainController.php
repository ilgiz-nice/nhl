<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Team;
use App\Match;
use App\Player;
use App\News;

class MainController extends Controller
{
    public function index() {
        $games = Match::Games()->get();
        $main_news = News::MainNews()->get();
        $tournament_teams = Team::Tournament();
        $tournament = Match::Tournament($tournament_teams);
        $news = News::Latest()->get();
        $stats = Player::Stats();
        return view('main.index', compact('games', 'main_news','tournament', 'news', 'stats'));
    }
}
