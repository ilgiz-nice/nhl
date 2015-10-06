<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Team;
use App\Match;
use App\Player;
use App\Coach;
use Excel;

class TeamsController extends Controller
{
    public function index() {
        $teams = Team::all();
        return view('teams.index', compact('teams'));
    }

    public function show($id) {
        $coach = Coach::where('id', $id)->get()[0]->name;
        $team = Team::findOrFail($id);
        $played = Match::TeamCalendar($id)->where('status', 'Завершен')->get();
        $notPlayed = Match::TeamCalendar($id)->where('status', 'Ожидается')->get();
        $players = Player::where('current_team', $id)->get();

        return view('teams.team', compact('team', 'notPlayed', 'played', 'players', 'coach'));
    }

    public function create(Request $request) {
        Excel::load($request->teams, function($reader) {
            $obj = $reader->toObject();
            foreach ($obj as $i) {
                Team::create([
                    'name'          => $i->name,
                    'short'         => $i->short,
                    'description'   => $i->description,
                    'coach_id'      => $i->coach_id,
                    'logo'          => $i->logo,
                    'photo'         => $i->photo,
                    'city'          => $i->city
                ]);
            }
        });

        return redirect('/manager');
    }

    public function export() {
        Excel::create('Команды', function($excel) {
            $excel->sheet('Матч', function($sheet) {
                $sheet->fromModel(Team::all());
            });

        })->download('xlsx');
    }
}
