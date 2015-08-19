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
    }

    public function result($path) {
        $this->XLSXtoArray($path);
        //Match::where('votes', '>', 100)->update(['status' => 2]);
        /*foreach ($sheet2 as $r)
        {
            Goal::create([
                'match_id'              => $insertedId,
                'team_id'               => $r[0],
                'player_id'             => $r[1],
                'player_goalkeeper_id'  => $r[2],
                'player_assist_1_id'    => $r[3],
                'player_assist_2_id'    => $r[4],
                'time'                  => $r[5],
                'bullitt'               => $r[6],
                'win_bullitt'           => $r[7],
                'win_goal'              => $r[8],
                'disparity'             => $r[9],
                'win_composition'       => $r[10],
                'lose_composition'      => $r[11]
            ]);
        }*/
    }

    public function export($array) {
        Excel::create('Filename', function($excel) use($array) {
            $excel->sheet('Матч', function($sheet) use($array) {
                $sheet->row(1, array(
                    'id матча', 'Состав домашней команды', 'Состав гостевой команды', 'Номер игры', 'Стадия', 'Статус',
                    'Дата', 'Время начала', 'Время окончания', 'id домашней команды', 'id гостевой команды',
                    'Количество зрителей', 'Количество голов домашней команды', 'Количество голов гостевой команды',
                    'Победа - основное время', 'Победа - овертайм', 'Поражение - основное время', 'Поражение - овертайм'
                ));
                $sheet->row(2, array(
                    $array['id'], '', '', $array['num'], '', '', $array['date'], '', '', $array['home'],
                    $array['guest'], '', '', '', '', '', '', ''
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

    public function XLSXtoArray($path) {
        /*
         * Parse XLSX to array
         */
        /*$file=file_get_contents('zip://' . $path . '#xl/sharedStrings.xml');
        $xml=(array)simplexml_load_string($file);
        $sst=array();
        foreach ($xml['si'] as $item=>$val)
        {
            $sst[]=iconv('UTF-8','UTF-8',(string)$val->t);
        }
        $sheet1 = array();
        $file=file_get_contents('zip://' . $path . '#xl/worksheets/sheet1.xml');
        $xml=simplexml_load_string($file);
        foreach ($xml->sheetData->row as $row)
        {
            $currow = array();
            foreach ($row->c as $c) {
                $value = (string)$c->v;
                $attrs = $c->attributes();
                if ($attrs['t'] == 's') {
                    $currow[] = $sst[$value];
                } else {
                    $currow[] = $value;
                }
            }
            $sheet1[] = $currow;
        }
        $sheet2 = array();
        $file=file_get_contents('zip://' . $path . '#xl/worksheets/sheet2.xml');
        $xml=simplexml_load_string($file);
        foreach ($xml->sheetData->row as $row)
        {
            $currow = array();
            foreach ($row->c as $c) {
                $value = (string)$c->v;
                $attrs = $c->attributes();
                if ($attrs['t'] == 's') {
                    $currow[] = $sst[$value];
                } else {
                    $currow[] = $value;
                }
            }
            $sheet2[] = $currow;
        }*/

        /*
         * Заполнение массива участников матча
         */
        /*$home_participants = array();
        $guest_participants = array();
        foreach ($sheet1 as $r)
        {
            $home_participants[] = $r[0];
            $guest_participants[] = $r[1];
        }
        $home_participants = implode(',', $home_participants);
        $guest_participants = implode(',', $guest_participants);

        return [$sheet1, $sheet2, $home_participants, $guest_participants];*/
        Excel::load($path, function($reader) {
            $result = $reader->toArray();
            dump($result);
        });
    }
}