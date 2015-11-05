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
        $main_news = News::MainNews()->get();
        $tournament = Match::Summary();
        $news = News::Latest()->get();
        $stats = Player::Stats();
        $matches = Match::with('homeTeam', 'guestTeam')->get();
        return view('main.index', compact('matches', 'main_news','tournament', 'news', 'stats'));
    }
}
