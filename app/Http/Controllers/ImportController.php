<?php

namespace App\Http\Controllers;

use App\Match;
use App\Goal;
use App\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Excel;

class ImportController extends Controller
{
    public function index() {
        $teams = $this->teams();
        $matches = $this->matches();
        return view('import/index', compact('teams', 'matches'));
    }

    public function teams() {
        $teams = Team::all();
        $array = array();

        foreach ($teams as $team) {
            $array[$team->id] = $team->name;
        }

        return $array;
    }

    public function matches() {
        $array = DB::table('match')
            ->select('home.name AS home', 'guest.name AS guest', 'match.*')
            ->leftJoin('teams AS home', 'home.id', '=', 'match.home_id')
            ->leftJoin('teams AS guest', 'guest.id', '=', 'match.guest_id')
            ->get();

        return $array;
    }

    public function store() {
        switch (Request::get('action')) {
            case 'match':
                $this->match(Request::all());
                break;
            case 'result':
                $this->result($_FILES['result']['tmp_name']);
                break;
            case 'export':
                $this->export(Request::all());
                break;
        }
    }

    public function match($array) { //import
        $active = DB::table('seasons')->select('id')->where('active', true)->get();
        $active = $active[0]->id;
        Match::create([
            'season_id'             => $active,
            'home_participants'     => null,
            'guest_participants'    => null,
            'num'                   => $array['num'],
            'stage'                 => null,
            'status'                => 'Ожидается',
            'date'                  => $array['date'],
            'start'                 => $array['start'],
            'finish'                => $array['finish'],
            'home_id'               => $array['home'],
            'guest_id'              => $array['guest'],
            'audience'              => null,
            'home_goals'            => null,
            'guest_goals'           => null,
            'win_main_time'         => null,
            'win_additional_time'   => null,
            'lose_main_time'        => null,
            'lose_additional_time'  => null
        ]);
    }

    public function result($path) { //update
        Excel::load($path, function($reader) {
            $array = $reader->toObject();
            dump($array);

            /*
             * Участники
             */
            $home_participants = array();
            $guest_participants = array();
            foreach ($array[0] as $r) {
                $home_participants[] = $r->sostav_domashney_komandy;
                $guest_participants[] = $r->sostav_gostevoy_komandy;
            }
            $home_participants = implode(',', $home_participants);
            $guest_participants = implode(',', $guest_participants);

            /*
             * Update
             */
            $row = $array[0][0];
            Match::where('id', '=', $row->id_matcha)->update([
                'stage' => $row->stadiya,
                'status' => $row->status,
                'date' => $row->data,
                'start' => $row->vremya_nachala,
                'finish' => $row->vremya_okonchaniya,
                'audience' => $row->kolichestvo_zriteley,
                'home_participants' => $home_participants,
                'guest_participants' => $guest_participants,
                'home_goals' => $row->kolichestvo_golov_domashney_komandy,
                'guest_goals' => $row->kolichestvo_golov_gostevoy_komandy,
                'win_main_time' => $row->pobeda_osnovnoe_vremya,
                'win_additional_time' => $row->pobeda_overtaym,
                'lose_main_time' => $row->porazhenie_osnovnoe_vremya,
                'lose_additional_time' => $row->porazhenie_overtaym
            ]);
            /*
             * Create
             */
            foreach ($array[1] as $r) {
                if (Goal::Exist($r->id_matcha, $r->vremya_gola)->count() != 0) {
                    Goal::UpdateGoals($r->id_matcha, $r->vremya_gola)->update([
                        'match_id'              => $r->id_matcha,
                        'team_id'               => $r->id_komandy,
                        'player_id'             => $r->id_zabivshego_igroka,
                        'player_goalkeeper_id'  => $r->id_vratarya,
                        'player_assist_1_id'    => $r->id_assist1,
                        'player_assist_2_id'    => $r->id_assist2,
                        'time'                  => $r->vremya_gola,
                        'bullitt'               => $r->bullit_01,
                        'win_bullitt'           => $r->pobednyy_bullit_01,
                        'win_goal'              => $r->pobednyy_gol_01,
                        'disparity'             => $r->neravenstvo,
                        'win_composition'       => $r->zabivshiy_sostav,
                        'lose_composition'      => $r->propustivshiy_sostav
                    ]);
                }
                else {
                    Goal::create([
                        'match_id'              => $r->id_matcha,
                        'team_id'               => $r->id_komandy,
                        'player_id'             => $r->id_zabivshego_igroka,
                        'player_goalkeeper_id'  => $r->id_vratarya,
                        'player_assist_1_id'    => $r->id_assist1,
                        'player_assist_2_id'    => $r->id_assist2,
                        'time'                  => $r->vremya_gola,
                        'bullitt'               => $r->bullit_01,
                        'win_bullitt'           => $r->pobednyy_bullit_01,
                        'win_goal'              => $r->pobednyy_gol_01,
                        'disparity'             => $r->neravenstvo,
                        'win_composition'       => $r->zabivshiy_sostav,
                        'lose_composition'      => $r->propustivshiy_sostav
                    ]);
                }
            }
        });
    }

    public function export($array) { //export
        Excel::create('Filename', function($excel) use($array) {
            $excel->sheet('Матч', function($sheet) use($array) {
                $sheet->row(1, array(
                    'Состав домашней команды', 'Состав гостевой команды', 'Номер игры', 'Стадия', 'Статус',
                    'Дата', 'Время начала', 'Время окончания', 'id домашней команды', 'id гостевой команды',
                    'Количество зрителей', 'Количество голов домашней команды', 'Количество голов гостевой команды',
                    'Победа - основное время', 'Победа - овертайм', 'Поражение - основное время', 'Поражение - овертайм',
                    'id матча'
                ));
                $sheet->row(2, array(
                    '', '', $array['num'], '', '', $array['date'], '', '', $array['home'],
                    $array['guest'], '', '', '', '', '', '', '', $array['id']
                ));
            });

            $excel->sheet('Голы', function($sheet) use($array) {
                $sheet->row(1, array(
                    'id матча', 'id команды', 'id забившего игрока', 'id вратаря', 'id ассист1', 'id ассист2',
                    'Время гола', 'Буллит 0/1', 'Победный буллит 0/1', 'Победный гол 0/1', 'Неравенство',
                    'Забивший состав', 'Пропустивший состав'
                ));
                $sheet->row(2, array(
                    $array['id'], '', '', '', '', '', '', '', '', '', '', '', ''
                ));
            });

        })->download('xlsx');
    }
}