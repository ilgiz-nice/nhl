<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Goal;

class Match extends Model
{
    protected $table = 'match';

    protected $fillable = [
        'season_id',
        'num',
        'stage',
        'status',
        'date',
        'start',
        'finish',
        'home_id',
        'guest_id',
        'audience',
        'home_participants',
        'guest_participants',
        'home_goals',
        'guest_goals',
        'win_main_time',
        'win_additional_time',
        'lose_main_time',
        'lose_additional_time'
    ];

    /*
     * Export - manager/index
     */

    public function scopeExport($query) {
        $query->select('match.*', 'home.name as home', 'guest.name as guest')
            ->leftJoin('teams AS home', 'home.id', '=', 'match.home_id')
            ->leftJoin('teams AS guest', 'guest.id', '=', 'match.guest_id')
            ->orderBy('date', 'DESC');
    }

    /*
     * Games - main/index
     */

    public function scopeGames($query) {
        $query->select('match.*', 'home.name as home', 'guest.name as guest')
            ->leftJoin('teams AS home', 'home.id', '=', 'match.home_id')
            ->leftJoin('teams AS guest', 'guest.id', '=', 'match.guest_id')
            ->orderBy('date', 'ASC');
    }
    /*
     * Используется в teams/team
     */

    public function scopeTeamCalendar($query, $id) {
        $query->select('match.*', 'home.name as home', 'guest.name as guest')
            ->where('match.home_id', $id)
            ->orWhere('match.guest_id', $id)
            ->leftJoin('teams AS home', 'home.id', '=', 'match.home_id')
            ->leftJoin('teams AS guest', 'guest.id', '=', 'match.guest_id')
            ->orderBy('date', 'ASC');
    }

    /*
     * Календарь/Результат (переделать)
     */

    public function scopeCalendar($query) {
        $query->select('match.*', 'home.name as home', 'guest.name as guest')
            ->leftJoin('teams AS home', 'home.id', '=', 'match.home_id')
            ->leftJoin('teams AS guest', 'guest.id', '=', 'match.guest_id')
            ->orderBy('date', 'ASC');
    }

    /*
     * Tournament - main/index && stats/index (to be)
     */

    public function scopeTournament($query, $output) {
        foreach($query->get() as $match) {
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

    /*
     * MatchInfo - /matches/match
     */

    public function scopeMatchInfo($query, $id) {
        $query->select('match.*', 'home.name as home', 'guest.name as guest', 'home.logo as home_logo', 'guest.logo as guest_logo',
            'home.city as home_city', 'guest.city as guest_city')
            ->leftJoin('teams AS home', 'home.id', '=', 'match.home_id')
            ->leftJoin('teams AS guest', 'guest.id', '=', 'match.guest_id')
            ->where('match.id', $id);;
    }

    /*
     * Summary - /players/player
     */

    public function scopeSummary($query, $id = null, $param = null) {
        $seasons = Season::all();
        $teams = Team::all();

        foreach ($seasons as $s) {
            $matchesGroup = Match::all()->where('stage', 'Группа')->where('season_id', $s->id);
            $matchesPlayoff = Match::all()->where('stage', 'Плеофф')->where('season_id', $s->id);

            foreach ($teams as $t) {
                //
            }
        }
    }
}
