<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Match;
use DB;
use Excel;
use App\Goal;

class MatchesController extends Controller
{
    public function show($id) {
        $match = Match::matchInfo($id)->get()[0];
        $goals = Goal::all()->where('match_id', $id);
        $title = $match->home . ' vs ' . $match->guest;
        return view('matches.match', compact('match', 'goals', 'title'));
    }

    public function create(Request $request) {
        $active = DB::table('seasons')->select('id')->where('active', true)->get();
        $active = $active[0]->id;
        Match::create([
            'season_id'             => $active,
            'home_participants'     => null,
            'guest_participants'    => null,
            'num'                   => $request->num,
            'stage'                 => null,
            'status'                => $request->status,
            'date'                  => $request->date,
            'start'                 => $request->start,
            'finish'                => $request->finish,
            'home_id'               => $request->home,
            'guest_id'              => $request->guest,
            'audience'              => null,
            'home_goals'            => null,
            'guest_goals'           => null,
            'win_main_time'         => null,
            'win_additional_time'   => null,
            'lose_main_time'        => null,
            'lose_additional_time'  => null
        ]);

        return redirect('/manager');
    }

    public function export(Request $request) {
        $filename = $request->home . '_vs_' . $request->guest;
        Excel::create($filename, function($excel) use($request) {
            $excel->sheet('Матч', function($sheet) use($request) {
                $sheet->row(1, array(
                    'id матча', 'Состав домашней команды', 'Состав гостевой команды', 'Номер игры', 'Стадия', 'Статус',
                    'Дата', 'Время начала', 'Время окончания', 'id домашней команды', 'id гостевой команды',
                    'Количество зрителей', 'Количество голов домашней команды', 'Количество голов гостевой команды',
                    'Победа - основное время', 'Победа - овертайм', 'Победа - буллиты',
                    'Поражение - основное время', 'Поражение - овертайм', 'Поражение - буллиты'
                ));
                $sheet->row(2, array(
                    $request->id, '', '', $request->num, '', '', $request->date, $request->start, $request->finish, $request->home_id,
                    $request->guest_id, '', '', '', '', '', '', '', '', ''
                ));
            });

            $excel->sheet('Голы', function($sheet) use($request) {
                $sheet->row(1, array(
                    'id матча', 'id команды', 'id забившего игрока', 'id вратаря', 'id ассист1', 'id ассист2',
                    'Время гола', 'Овертайм 0/1', 'Буллит 0/1', 'Победный буллит 0/1', 'Победный гол 0/1',
                    'Неравенство', 'Забивший состав', 'Пропустивший состав'
                ));
                $sheet->row(2, array(
                    $request->id, '', '', '', '', '', '', '', '', '', '', '', ''
                ));
            });

        })->download('xlsx');
    }

    public function result(Request $request) {
        Excel::load($request->result->getRealPath(), function($reader) {
            $array = $reader->toObject();

            $row = $array[0][0];
            dd($array[1]);
            Match::where('id', '=', $row->id_matcha)->update([
                'stage' => $row->stadiya,
                'status' => $row->status,
                'date' => $row->data,
                'start' => $row->vremya_nachala,
                'finish' => $row->vremya_okonchaniya,
                'audience' => $row->kolichestvo_zriteley,
                'home_participants' => $row->sostav_domashney_komandy,
                'guest_participants' => $row->sostav_gostevoy_komandy,
                'home_goals' => $row->kolichestvo_golov_domashney_komandy,
                'guest_goals' => $row->kolichestvo_golov_gostevoy_komandy,
                'win_main_time' => $row->pobeda_osnovnoe_vremya,
                'win_additional_time' => $row->pobeda_overtaym,
                'win_bullitt' => $row->pobeda_bullity,
                'lose_main_time' => $row->porazhenie_osnovnoe_vremya,
                'lose_additional_time' => $row->porazhenie_overtaym,
                'lose_bullitt' => $row->porazhenie_bullity
            ]);
            foreach ($array[1] as $r) {
                Goal::create([
                    'match_id'              => $r->id_matcha,
                    'team_id'               => $r->id_komandy,
                    'player_id'             => $r->id_zabivshego_igroka,
                    'player_goalkeeper_id'  => $r->id_vratarya,
                    'player_assist_1_id'    => $r->id_assist1,
                    'player_assist_2_id'    => $r->id_assist2,
                    'time'                  => $r->vremya_gola,
                    'overtime'              => $r->overtaym_01,
                    'bullitt'               => $r->bullit_01,
                    'win_bullitt'           => $r->pobednyy_bullit_01,
                    'win_goal'              => $r->pobednyy_gol_01,
                    'disparity'             => $r->neravenstvo,
                    'win_composition'       => $r->zabivshiy_sostav,
                    'lose_composition'      => $r->propustivshiy_sostav
                ]);
            }
        });

        redirect('/manager');
    }
}
