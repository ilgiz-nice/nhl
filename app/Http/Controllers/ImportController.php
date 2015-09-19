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

class ImportController extends Controller
{
    public function index() {
        $teams = Team::Select();
        $matches = Match::Export()->get();
        Team::Select();
        return view('import/index', compact('teams', 'matches'));
    }

    /*
     * Распределение по методам
     */

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
            case 'teams':
                $this->teams($_FILES['teams']['tmp_name']);
                break;
            case 'players':
                $this->players($_FILES['players']['tmp_name']);
                break;
            case 'seasons':
                $this->seasons(Request::all());
                break;
        }

        redirect('/import');
    }

    /*
     * Внесение матча
     * @param - введенные данные
     */

    public function match($array) {
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

        redirect('/import');
    }

    /*
     * Внесение информации о матче, или обновлении.
     * @param - excel path
     */

    public function result($path) { //update
        Excel::load($path, function($reader) {
            $array = $reader->toObject();

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
                'home_participants' => $row->sostav_domashney_komandy,
                'guest_participants' => $row->sostav_gostevoy_komandy,
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
        });

        redirect('/import');
    }

    /*
     * Экспорт матча
     * param @array - массив с известными о матче данными
     */

    public function export($array) {
        $filename = $array['home'] . '_vs_' . $array['guest'];
        Excel::create($filename, function($excel) use($array) {
            $excel->sheet('Матч', function($sheet) use($array) {
                $sheet->row(1, array(
                    'id матча', 'Состав домашней команды', 'Состав гостевой команды', 'Номер игры', 'Стадия', 'Статус',
                    'Дата', 'Время начала', 'Время окончания', 'id домашней команды', 'id гостевой команды',
                    'Количество зрителей', 'Количество голов домашней команды', 'Количество голов гостевой команды',
                    'Победа - основное время', 'Победа - овертайм', 'Поражение - основное время', 'Поражение - овертайм'
                ));
                $sheet->row(2, array(
                    $array['id'], '', '', $array['num'], '', '', $array['date'], $array['start'], $array['finish'], $array['home_id'],
                    $array['guest_id'], '', '', '', '', '', '', ''
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

        redirect('/import');
    }

    /*
     * Импорт команд
     */

    public function teams($path) {
        Excel::load($path, function($reader) {
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
    }

    /*
     * Импорт игроков
     */

    public function players($path)
    {
        Excel::load($path, function ($reader) {
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
                dump($friendly);
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
    }

    /*
     * Добавление сезона
    */

    public function seasons($array) {
        Season::create([
            'year' => $array['year'],
            'participants' => 'Участники сезона',
            'placement' => 'Итоговое расположение',
            'active' => false
        ]);
    }
}