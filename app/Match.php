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

        $array = [];

        foreach ($teams as $t) {
            $object = (object) array();
            $object->teamId = $t->id;
            $object->playerId = NULL;
            $object->teamName = $t->name;
            $object->playerName = NULL;
            $object->games = 0;
            $object->winMain = 0;
            $object->winOvertime = 0;
            $object->loseMain = 0;
            $object->loseOvertime = 0;
            $object->winBullits = 0;
            $object->loseBullits = 0;
            $object->goalsGiven = 0;
            $object->goalsTaken = 0;
            $object->num = NULL;
            $object->goals = 0;
            $object->assists = 0;
            $object->points = 0;
            $object->plusMinus = 0;
            $object->penaltyTime = 0;
            $object->goalsEven = 0;
            $object->goalsMore = 0;
            $object->goalsLess = 0;
            $object->goalsOvertime = 0;
            $object->goalsWin = 0;
            $object->bullitsWin = 0;
            array_push($array, $object);
        }

        foreach ($seasons as $s) {
            $matchesGroup = Match::all()->where('stage', 'Группа')->where('season_id', $s->id);
            $matchesPlayoff = Match::all()->where('stage', 'Плейофф')->where('season_id', $s->id);
            $matchesTotal = Match::all()->where('season_id', $s->id);

            foreach ($matchesGroup as $m) { //summaryGroup
                foreach ($teams as $t) { //summaryTeam
                    if ($m->home_id == $t->id OR $m->guest_id == $t->id) {
                        foreach ($array as $a) {
                            if ($a->teamId == $t->id) {
                                // Количество игр
                                $a->games = $a->games + 1;
                                // Победы и проигрыши в основное, дополнительное и дополнительное по буллитам
                                if ($m->win_main_time == $a->teamId) {
                                    $a->winMain = $a->winMain + 1;
                                }
                                if ($m->win_additional_time == $a->teamId) {
                                    $a->winOvertime = $a->winOvertime + 1;
                                }
                                if ($m->lose_main_time == $a->teamId) {
                                    $a->loseMain = $a->loseMain + 1;
                                }
                                if ($m->lose_additional_time == $a->teamId) {
                                    $a->loseOvertime = $a->loseOvertime + 1;
                                }
                                if ($m->win_bullitt == $a->teamId) {
                                    $a->winBullitt = $a->winBullitt + 1;
                                }
                                if ($m->lose_bullitt == $a->teamId) {
                                    $a->loseBullitt = $a->loseBullitt + 1;
                                }
                                // Голы забиты и пропущены
                                if ($m->home_id == $t->id) {
                                    $a->goalsGiven = $a->goalsGiven + $m->home_goals;
                                    $a->goalsTaken = $a->goalsTaken + $m->guest_goals;
                                }
                                if ($m->guest_id == $t->id) {
                                    $a->goalsTaken = $a->goalsTaken + $m->home_goals;
                                    $a->goalsGiven = $a->goalsGiven + $m->guest_goals;
                                }
                                // Очки
                                $a->poins = $a->winMain * 3 + $a->winOvertime * 2 + $a->winBullitt * 2 + $a->loseOvertime + $a->loseBullitt;
                            }
                        }
                    }
                }
            }
        }

        dd($array);
    }
}
