<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Team;
use Excel;

class TeamsController extends Controller
{
    public function index() {
        $teams = Team::all();
        return view('teams.index', compact('teams'));
    }

    public function show($id) {
        $team = Team::findOrFail($id);

        return view('teams.team', compact('team'));
    }

    public function create(Request $request) {
        Excel::load($request->teams, function($reader) {
            $obj = $reader->toObject();
            foreach ($obj as $i) {
                Team::create([
                    'name'          => $i->name,
                    'description'   => $i->description,
                    'coach_id'      => $i->coach_id,
                    'logo'          => $i->logo,
                    'photo'         => $i->photo
                ]);
            }
        });

        return redirect('/manager');
    }

    public function export() {
        Excel::create('Команды', function($excel) {
            $excel->sheet('Матч', function($sheet) {
                $sheet->fromModel(Teams::all());
            });

        })->download('xlsx');
    }
}
