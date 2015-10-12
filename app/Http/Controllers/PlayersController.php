<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Player;
use App\Match;
use Excel;

class PlayersController extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function show($id) {
        $player = Player::findOrFail($id);
        $summary = Match::Summary($id);

        return view('players.player', compact('player', 'summary'));
    }

    public function create(Request $request) {
        Excel::load($request->players, function ($reader) {
            $obj = $reader->toObject();
            foreach ($obj[0] as $i) {
                if (strlen($i->current_team) == 1) {
                    $friendly = '0' . $i->current_team;
                } else if (strlen($i->current_team == 2)) {
                    $friendly = $i->current_team;
                }
                if (strlen($i->num) == 1) {
                    $friendly .= '00' . $i->num;
                } else if (strlen($i->num) == 2) {
                    $friendly .= '0' . $i->num;
                } else if (strlen($i->num) == 3) {
                    $friendly .= $i->num;
                }
                Player::create([
                    'friendly' => $friendly,
                    'name' => $i->name,
                    'current_team' => $i->current_team,
                    'num' => $i->num,
                    'height' => $i->height,
                    'weight' => $i->weight,
                    'birthday' => $i->birthday,
                    'role' => $i->role,
                    'hand' => $i->hand,
                    'city' => $i->city,
                    'past_teams' => $i->past_teams,
                    'photo' => $i->photo
                ]);
            }
        });

        return redirect('/manager');
    }

    public function export(Request $request) {
        Excel::create('Игроки', function($excel) {
            $excel->sheet('Матч', function($sheet) {
                $sheet->fromModel(Player::all());
            });

        })->download('xlsx');
    }
}
