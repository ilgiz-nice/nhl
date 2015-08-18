<?php

namespace App\Http\Controllers;

use App\Match;
use App\Goal;
use App\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class ImportController extends Controller
{
    public function index() {
        $teams = $this->teams();
        return view('import/index', compact('teams'));
    }

    public function teams() {
        $teams = Team::all();
        $array = array();

        foreach ($teams as $team) {
            $array[$team->id] = $team->name;
        }

        return $array;
    }

    /*public function store() {
        $path = $_FILES['file1']['tmp_name'];
        $file=file_get_contents('zip://' . $path . '#xl/sharedStrings.xml');
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
        }
        /*
         * Активный сезон
         */
        //$active = DB::select('SELECT id FROM seasons WHERE active = true');
        //$active = $active[0]->id;
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
        /*
         * Внесение в базу данных
         */
        /*foreach ($sheet1 as $r)
        {
            $match = Match::create([
                'season_id'             => $active,
                'home_participants'     => $home_participants,
                'guest_participants'    => $guest_participants,
                'num'                   => $r[2],
                'stage'                 => $r[3],
                'status'                => $r[4],
                'date'                  => $r[5],
                'start'                 => $r[6],
                'finish'                => $r[7],
                'home_id'               => $r[8],
                'guest_id'              => $r[9],
                'audience'              => $r[10],
                'home_goals'            => $r[11],
                'guest_goals'           => $r[12],
                'win_main_time'         => $r[13],
                'win_additional_time'   => $r[14],
                'lose_main_time'        => $r[15],
                'lose_additional_time'  => $r[16]
            ]);
            $insertedId = $match->id;
            break;
        }
        foreach ($sheet2 as $r)
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
        }
    }*/

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
        //На сайте
        Match::create([
            //
        ]);
    }

    public function result($path) {
        User::where('votes', '>', 100)->update(['status' => 2]);
    }

    public function export($array) {
        $list = array (
            array('Состав домашней команды', 'Состав гостевой команды', 'Номер игры', 'Стадия', 'Статус', 'Дата',
                'Время начала', 'Время окончания', 'id домашней команды', 'id гостевой команды', 'Количество зрителей',
                'Количество голов домашней команды', 'Количество голов гостевой команды', 'Победа - основное время',
                'Победа - овертайм', 'Поражение - основное время', 'Поражение - овертайм'),
            array('', '', $array['num'], '', '', '', '', '', $array['home'], $array['guest'], '', '', '', '', '', '', '')
        );

        $fp = fopen('file.xlsx', 'w');

        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);

        $file = 'file.xlsx';
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");
        readfile($file);
    }
}