<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Team;
use App\Match;
use App\Goal;
use App\Player;

class MainController extends Controller
{
    public function index() {
        $calendar = $this->calendar();
        $best = $this->best();
        $tournament = $this->tournament();
        //$news = $this->news();
        //test

        return view('main.index', compact('calendar', 'best', 'tournament', 'news'));
    }

    public function calendar() {
        $array = DB::table('match')
            ->select('home.name AS home', 'guest.name AS guest', 'match.home_id', 'match.guest_id', 'match.home_goals', 'match.guest_goals', 'match.date AS date')
            ->leftJoin('teams AS home', 'home.id', '=', 'match.home_id')
            ->leftJoin('teams AS guest', 'guest.id', '=', 'match.guest_id')
            ->get();

        return $array;
    }

    public function tournament() {
        /*
         * Исходные массивы
         */
        $output = array();
        $teams = Team::all();
        $matches = Match::all();

        /*
         * Выходной массив
         */
        foreach ($teams as $team) {
            $inner = array();
            $inner['id'] = $team->id;
            $inner['name'] = $team->name;
            $inner['games'] = 0;
            $inner['wins'] = 0;
            $inner['wins_overtime'] = 0;
            $inner['wins_bullitt'] = 0;
            $inner['loses_bullitt'] = 0;
            $inner['loses_overtime'] = 0;
            $inner['loses'] = 0;
            $inner['goals'] = '0 - 0';
            $inner['points'] = 0;
            $output[] = $inner;
        }

        /*
         * Изменение выходного массива
         */
        foreach($matches as $match) {
            /*
             * Получение индекса
             */
            $home_id = $match->home_id;
            $guest_id = $match->guest_id;
            $count = count($output);
            for ($i = 0; $i < $count; $i++) {
                if ($output[$i]['id'] == $home_id) {
                    $h_i = $i; //home_index
                }
                if ($output[$i]['id'] == $guest_id) {
                    $g_i = $i; //guest_index
                }
            }

            /*
             * Логика
             */

            /*
             * Количество игр
             */
            array_set($output[$h_i], 'games', array_get($output[$h_i], 'games') + 1);
            array_set($output[$g_i], 'games', array_get($output[$g_i], 'games') + 1);

            /*
             * Выигрыши в основное и дополнительное время
             */
            if ($match->win_main_time == $home_id) {
                array_set($output[$h_i], 'wins', array_get($output[$h_i], 'wins') + 1);
            } else if ($match->win_main_time == $guest_id) {
                array_set($output[$g_i], 'wins', array_get($output[$g_i], 'wins') + 1);
            }
            if ($match->win_additional_time == $home_id) {
                array_set($output[$h_i], 'wins_overtime', array_get($output[$h_i], 'wins_overtime') + 1);
            } else if ($match->win_additional_time == $guest_id) {
                array_set($output[$g_i], 'wins_overtime', array_get($output[$g_i], 'wins_overtime') + 1);
            }
            if ($match->lose_main_time == $home_id) {
                array_set($output[$h_i], 'loses', array_get($output[$h_i], 'loses') + 1);
            } else if ($match->lose_main_time == $guest_id) {
                array_set($output[$g_i], 'loses', array_get($output[$g_i], 'loses') + 1);
            }
            if ($match->lose_additional_time == $home_id) {
                array_set($output[$h_i], 'loses_overtime', array_get($output[$h_i], 'loses_overtime') + 1);
            } else if ($match->lose_additional_time == $guest_id) {
                array_set($output[$g_i], 'loses_overtime', array_get($output[$g_i], 'loses_overtime') + 1);
            }

            /*
             * Число забитых шайб
             */
            $home_score = explode(' - ', $output[$h_i]['goals']); //Счёт домашней команды
            $guest_score = explode(' - ', $output[$g_i]['goals']);
            $home_goals = $match->home_goals; //Число шайб домашней команды
            $guest_goals = $match->guest_goals; //Число шайб гостевой команды
            $home_score[0] = $home_score[0] + $home_goals; //Число забитых домашней команды
            $home_score[1] = $home_score[1] + $guest_goals; //Число пропущенных домашней команды
            $guest_score[0] = $guest_score[0] + $guest_goals;
            $guest_score[1] = $guest_score[1] + $home_goals;
            $home_score = implode(' - ', $home_score);
            $guest_score = implode(' - ', $guest_score);
            array_set($output[$h_i], 'goals', $home_score);
            array_set($output[$g_i], 'goals', $guest_score);

            /*
             * Выигрыши по буллитам
             */
            $goals = Goal::all()->where('match_id', $match->id);
            foreach ($goals as $goal) {
                if ($goal->bullitt == true AND $goal->win_bullitt == true) {
                    if ($home_id == $goal->team_id) {
                        array_set($output[$h_i], 'wins_overtime', array_get($output[$h_i], 'wins_overtime') - 1);
                        array_set($output[$h_i], 'wins_bullitt', array_get($output[$h_i], 'wins_bullitt') + 1);
                        array_set($output[$g_i], 'loses_overtime', array_get($output[$g_i], 'loses_overtime') - 1);
                        array_set($output[$g_i], 'loses_bullitt', array_get($output[$g_i], 'loses_bullitt') + 1);
                    } else if ($guest_id == $goal->team_id) {
                        array_set($output[$g_i], 'wins_overtime', array_get($output[$g_i], 'wins_overtime') - 1);
                        array_set($output[$g_i], 'wins_bullitt', array_get($output[$g_i], 'wins_bullitt') + 1);
                        array_set($output[$h_i], 'loses_overtime', array_get($output[$h_i], 'loses_overtime') - 1);
                        array_set($output[$h_i], 'loses_bullitt', array_get($output[$h_i], 'loses_bullitt') + 1);
                    }
                }
            }

            /*
             * Очки
             */
            $point_home = array_get($output[$h_i], 'wins') * 3 +
                array_get($output[$h_i], 'wins_overtime') *2 + array_get($output[$h_i], 'wins_bullitt') *2 +
                array_get($output[$h_i], 'loses_bullitt') + array_get($output[$h_i], 'loses_overtime');
            $point_guest = array_get($output[$g_i], 'wins') * 3 +
                array_get($output[$g_i], 'wins_overtime') *2 + array_get($output[$g_i], 'wins_bullitt') *2 +
                array_get($output[$g_i], 'loses_bullitt') + array_get($output[$g_i], 'loses_overtime');
            array_set($output[$h_i], 'points', $point_home);
            array_set($output[$g_i], 'points', $point_guest);
        }

        return $output;
    }

    public function best() {

        $top_goals = DB::table('players as p')
            ->select('p.name AS name',
                DB::raw('COUNT(a.id) as goals'),
                DB::raw('COUNT(a.id) * 3 as total'))
            ->leftJoin('goals as a', 'a.player_id', '=', 'p.id')
            ->groupBy('p.id')
            ->orderBy('total', 'DESC')
            ->orderBy('name')
            ->get();
        $top_assist = DB::table('players AS p')
            ->select('p.name AS name',
                DB::raw('COUNT(a.player_assist_1_id) AS assist1'),
                DB::raw('COUNT(b.player_assist_2_id) AS assist2'),
                DB::raw('COUNT(a.player_assist_1_id) * 2 + COUNT(b.player_assist_2_id) AS total'))
            ->leftJoin('goals AS a', 'a.player_assist_1_id', '=', 'p.id')
            ->leftJoin('goals AS b', 'b.player_assist_2_id', '=', 'p.id')
            ->groupBy('p.id')
            ->orderBy('total', 'DESC')
            ->orderBy('name')
            ->get();

        $array = array();
        $sort = array();
        $count = Player::all()->count();

        for ($i=0;$i<$count;$i++) {
            if ($i>=5) {
                break;
            }
            $array['goal'][$i]['num'] = $i + 1;
            $array['goal'][$i]['name'] = $top_goals[$i]->name;
            $array['goal'][$i]['goals'] = $top_goals[$i]->goals;
            $array['goal'][$i]['points'] = $top_goals[$i]->total;
        }

        for($i=0;$i<$count;$i++) {
            if ($i>=5) {
                break;
            }
            $array['assist'][$i]['num'] = $i + 1;
            $array['assist'][$i]['name'] = $top_assist[$i]->name;
            $array['assist'][$i]['assist1'] = $top_assist[$i]->assist1;
            $array['assist'][$i]['assist2'] = $top_assist[$i]->assist2;
            $array['assist'][$i]['points'] = $top_assist[$i]->total;
        }

        for($i=0;$i<$count;$i++) {
            $sort['goal_assist'][$i]['num'] = $i + 1;
            $sort['goal_assist'][$i]['name'] = $top_goals[$i]->name;
            $sort['goal_assist'][$i]['goals'] = $top_goals[$i]->goals;
            for ($d=0;$d<$count;$d++) {
                if ($top_goals[$i]->name == $top_assist[$d]->name) {
                    $sort['goal_assist'][$i]['assist1'] = $top_assist[$d]->assist1;
                    $sort['goal_assist'][$i]['assist2'] = $top_assist[$d]->assist2;
                    $sort['goal_assist'][$i]['points'] = $top_goals[$i]->total + $top_assist[$d]->total;
                }
            }
        }

        usort($sort['goal_assist'], function($a, $b) {
            return $b['points'] - $a['points'];
        });

        for ($i=0;$i<$count;$i++) {
            if ($i>=5) {
                break;
            }
            $array['goal_assist'][$i] = $sort['goal_assist'][$i];
            $array['goal_assist'][$i]['num'] = $i + 1;
        }

        return $array;
    }
}
