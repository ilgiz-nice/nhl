<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class GamesController extends Controller
{
    public function index() {
        $games = DB::select('
SELECT home.name AS home,
  guest.name AS guest,
  `match`.*

FROM `match`

LEFT JOIN teams AS home
	ON home.id = match.home_id

LEFT JOIN teams AS guest
	ON guest.id = match.guest_id
	');

        return view('games.index', compact('games'));
    }
}
