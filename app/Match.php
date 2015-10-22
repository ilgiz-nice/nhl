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
            ->where('match.id', $id);
    }

    /*
     * Summary - /players/player
     */

    public function scopeSummary($query, $id = null, $param = null) {
        $seasons = Season::all();
        $teams = Team::all();
        $players = Player::all();
        $goals = Goal::all();

        $arrayTeams = [];
        $arrayPlayers = [];

        foreach ($seasons as $s) {
            $object = (object) array();
            $object->{'seasons'} = array();
            $object->{'group'} = array();
            $object->{'playoff'} = array();
            $object->{'total'} = array();
            array_push($arrayTeams, $object);
            $object = (object) array();
            $object->{$s->season} = array();
            array_push($arrayTeams[0]->{'seasons'}, $object);
            $object = (object) array();
            $object->{'group'} = array();
            $object->{'playoff'} = array();
            array_push($arrayTeams[0]->{'seasons'}[0]->{$s->season}, $object);
            foreach ($teams as $t) {
                $object = (object) array();
                $object->id = $t->id;
                $object->name = $t->name;
                $object->logo = $t->logo;
                $object->games = 0;
                $object->winMain = 0;
                $object->winOvertime = 0;
                $object->loseMain = 0;
                $object->loseOvertime = 0;
                $object->winBullitt = 0;
                $object->loseBullitt = 0;
                $object->goalsGiven = 0;
                $object->goalsTaken = 0;
                $object->points = 0;
                array_push($arrayTeams[0]->{'seasons'}[0]->{$s->season}[0]->{'group'}, $object);
                $object = (object) array();
                $object->id = $t->id;
                $object->name = $t->name;
                $object->logo = $t->logo;
                $object->games = 0;
                $object->winMain = 0;
                $object->winOvertime = 0;
                $object->loseMain = 0;
                $object->loseOvertime = 0;
                $object->winBullitt = 0;
                $object->loseBullitt = 0;
                $object->goalsGiven = 0;
                $object->goalsTaken = 0;
                $object->points = 0;
                array_push($arrayTeams[0]->{'seasons'}[0]->{$s->season}[0]->{'playoff'}, $object);
                $object = (object) array();
                $object->id = $t->id;
                $object->name = $t->name;
                $object->logo = $t->logo;
                $object->games = 0;
                $object->winMain = 0;
                $object->winOvertime = 0;
                $object->loseMain = 0;
                $object->loseOvertime = 0;
                $object->winBullitt = 0;
                $object->loseBullitt = 0;
                $object->goalsGiven = 0;
                $object->goalsTaken = 0;
                $object->points = 0;
                array_push($arrayTeams[0]->{'group'}, $object);
                $object = (object) array();
                $object->id = $t->id;
                $object->name = $t->name;
                $object->logo = $t->logo;
                $object->games = 0;
                $object->winMain = 0;
                $object->winOvertime = 0;
                $object->loseMain = 0;
                $object->loseOvertime = 0;
                $object->winBullitt = 0;
                $object->loseBullitt = 0;
                $object->goalsGiven = 0;
                $object->goalsTaken = 0;
                $object->points = 0;
                array_push($arrayTeams[0]->{'playoff'}, $object);
                $object = (object) array();
                $object->id = $t->id;
                $object->name = $t->name;
                $object->logo = $t->logo;
                $object->games = 0;
                $object->winMain = 0;
                $object->winOvertime = 0;
                $object->loseMain = 0;
                $object->loseOvertime = 0;
                $object->winBullitt = 0;
                $object->loseBullitt = 0;
                $object->goalsGiven = 0;
                $object->goalsTaken = 0;
                $object->points = 0;
                array_push($arrayTeams[0]->{'total'}, $object);
            }
        } //Шаблон для команд

        foreach ($seasons as $s) {
            $object = (object) array();
            $object->{'seasons'} = array();
            $object->{'group'} = array();
            $object->{'playoff'} = array();
            $object->{'total'} = array();
            array_push($arrayPlayers, $object);
            $object = (object) array();
            $object->{$s->season} = array();
            array_push($arrayPlayers[0]->{'seasons'}, $object);
            $object = (object) array();
            $object->{'group'} = array();
            $object->{'playoff'} = array();
            array_push($arrayPlayers[0]->{'seasons'}[0]->{$s->season}, $object);
            foreach ($players as $p) {
                $object = (object) array();
                $object->id = $p->id;
                $object->name = $p->name;
                $object->num = $p->num;
                $object->stage = NULL;
                $object->season = NULL;
                $object->teamId = NULL;
                $object->teamName = NULL;
                $object->games = 0; //goals
                $object->goals = 0; //goals
                $object->assists = 0; //goals
                $object->points = 0; //goals
                $object->plusMinus = 0; //goals
                $object->penaltyTime = 0; //penalty
                $object->goalsEven = 0; //goals
                $object->goalsMore = 0; //goals
                $object->goalsLess = 0; //goals
                $object->goalsOvertime = 0; //надо добавить
                $object->goalsWin = 0; //goals
                $object->bullitsWin = 0; //goals
                array_push($arrayPlayers[0]->{'seasons'}[0]->{$s->season}[0]->{'group'}, $object);
                $object = (object) array();
                $object->id = $p->id;
                $object->name = $p->name;
                $object->num = $p->num;
                $object->stage = NULL;
                $object->season = NULL;
                $object->teamId = NULL;
                $object->teamName = NULL;
                $object->games = 0; //goals
                $object->goals = 0; //goals
                $object->assists = 0; //goals
                $object->points = 0; //goals
                $object->plusMinus = 0; //goals
                $object->penaltyTime = 0; //penalty
                $object->goalsEven = 0; //goals
                $object->goalsMore = 0; //goals
                $object->goalsLess = 0; //goals
                $object->goalsOvertime = 0; //надо добавить
                $object->goalsWin = 0; //goals
                $object->bullitsWin = 0; //goals
                array_push($arrayPlayers[0]->{'seasons'}[0]->{$s->season}[0]->{'playoff'}, $object);
                $object = (object) array();
                $object->id = $p->id;
                $object->name = $p->name;
                $object->num = $p->num;
                $object->stage = NULL;
                $object->season = NULL;
                $object->teamId = NULL;
                $object->teamName = NULL;
                $object->games = 0; //goals
                $object->goals = 0; //goals
                $object->assists = 0; //goals
                $object->points = 0; //goals
                $object->plusMinus = 0; //goals
                $object->penaltyTime = 0; //penalty
                $object->goalsEven = 0; //goals
                $object->goalsMore = 0; //goals
                $object->goalsLess = 0; //goals
                $object->goalsOvertime = 0; //надо добавить
                $object->goalsWin = 0; //goals
                $object->bullitsWin = 0; //goals
                array_push($arrayPlayers[0]->{'group'}, $object);
                $object = (object) array();
                $object->id = $p->id;
                $object->name = $p->name;
                $object->num = $p->num;
                $object->stage = NULL;
                $object->season = NULL;
                $object->teamId = NULL;
                $object->teamName = NULL;
                $object->games = 0; //goals
                $object->goals = 0; //goals
                $object->assists = 0; //goals
                $object->points = 0; //goals
                $object->plusMinus = 0; //goals
                $object->penaltyTime = 0; //penalty
                $object->goalsEven = 0; //goals
                $object->goalsMore = 0; //goals
                $object->goalsLess = 0; //goals
                $object->goalsOvertime = 0; //надо добавить
                $object->goalsWin = 0; //goals
                $object->bullitsWin = 0; //goals
                array_push($arrayPlayers[0]->{'playoff'}, $object);
                $object = (object) array();
                $object->id = $p->id;
                $object->name = $p->name;
                $object->num = $p->num;
                $object->stage = NULL;
                $object->season = NULL;
                $object->teamId = NULL;
                $object->teamName = NULL;
                $object->games = 0; //goals
                $object->goals = 0; //goals
                $object->assists = 0; //goals
                $object->points = 0; //goals
                $object->plusMinus = 0; //goals
                $object->penaltyTime = 0; //penalty
                $object->goalsEven = 0; //goals
                $object->goalsMore = 0; //goals
                $object->goalsLess = 0; //goals
                $object->goalsOvertime = 0; //надо добавить
                $object->goalsWin = 0; //goals
                $object->bullitsWin = 0; //goals
                array_push($arrayPlayers[0]->{'total'}, $object);
            }
        } //Шаблон для игроков

        foreach ($seasons as $s) {
            $matchesGroup = Match::all()->where('season_id', $s->id)->where('stage', 'Группа')->where('status', 'Завершен');
            $matchesPlayoff = Match::all()->where('season_id', $s->id)->where('stage', 'Плейофф')->where('status', 'Завершен');

            foreach ($matchesGroup as $m) { // Группа
                foreach ($teams as $t) { // Команды
                    if ($m->home_id == $t->id OR $m->guest_id == $t->id) {
                        foreach ($arrayTeams[0]->{'seasons'}[0]->{$s->season}[0]->{'group'} as $a) {
                            if ($a->id == $t->id) {
                                // Количество игр
                                $a->games = $a->games + 1;
                                // Победы и проигрыши в основное, дополнительное и дополнительное по буллитам
                                if ($m->win_main_time == $a->id) {
                                    $a->winMain = $a->winMain + 1;
                                }
                                if ($m->win_additional_time == $a->id) {
                                    $a->winOvertime = $a->winOvertime + 1;
                                }
                                if ($m->lose_main_time == $a->id) {
                                    $a->loseMain = $a->loseMain + 1;
                                }
                                if ($m->lose_additional_time == $a->id) {
                                    $a->loseOvertime = $a->loseOvertime + 1;
                                }
                                if ($m->win_bullitt == $a->id) {
                                    $a->winBullitt = $a->winBullitt + 1;
                                }
                                if ($m->lose_bullitt == $a->id) {
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
                                $a->points = $a->winMain * 3 + $a->winOvertime * 2 + $a->winBullitt * 2 + $a->loseOvertime + $a->loseBullitt;
                            }
                        } //Сезон->Группа

                        foreach ($arrayTeams[0]->{'group'} as $a) {
                            if ($a->id == $t->id) {
                                // Количество игр
                                $a->games = $a->games + 1;
                                // Победы и проигрыши в основное, дополнительное и дополнительное по буллитам
                                if ($m->win_main_time == $a->id) {
                                    $a->winMain = $a->winMain + 1;
                                }
                                if ($m->win_additional_time == $a->id) {
                                    $a->winOvertime = $a->winOvertime + 1;
                                }
                                if ($m->lose_main_time == $a->id) {
                                    $a->loseMain = $a->loseMain + 1;
                                }
                                if ($m->lose_additional_time == $a->id) {
                                    $a->loseOvertime = $a->loseOvertime + 1;
                                }
                                if ($m->win_bullitt == $a->id) {
                                    $a->winBullitt = $a->winBullitt + 1;
                                }
                                if ($m->lose_bullitt == $a->id) {
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
                                $a->points = $a->winMain * 3 + $a->winOvertime * 2 + $a->winBullitt * 2 + $a->loseOvertime + $a->loseBullitt;
                            }
                        } //Группа

                        foreach ($arrayTeams[0]->{'total'} as $a) {
                            if ($a->id == $t->id) {
                                // Количество игр
                                $a->games = $a->games + 1;
                                // Победы и проигрыши в основное, дополнительное и дополнительное по буллитам
                                if ($m->win_main_time == $a->id) {
                                    $a->winMain = $a->winMain + 1;
                                }
                                if ($m->win_additional_time == $a->id) {
                                    $a->winOvertime = $a->winOvertime + 1;
                                }
                                if ($m->lose_main_time == $a->id) {
                                    $a->loseMain = $a->loseMain + 1;
                                }
                                if ($m->lose_additional_time == $a->id) {
                                    $a->loseOvertime = $a->loseOvertime + 1;
                                }
                                if ($m->win_bullitt == $a->id) {
                                    $a->winBullitt = $a->winBullitt + 1;
                                }
                                if ($m->lose_bullitt == $a->id) {
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
                                $a->points = $a->winMain * 3 + $a->winOvertime * 2 + $a->winBullitt * 2 + $a->loseOvertime + $a->loseBullitt;
                            }
                        } //Итого
                    }
                }

                if ($id != null) { // Игроки
                    foreach ($players as $p) {
                        foreach ($goals as $g) {
                            foreach ($arrayPlayers[0]->{'seasons'}[0]->{$s->season}[0]->{'group'} as $a) {
                                if ($a->id == $p->id) {
                                    dump('Группа');
                                    $a->stage = 'Группа';
                                    $a->season = $s->season;
                                    $a->teamId = Team::find($p->current_team)->id;
                                    $a->teamName = Team::find($p->current_team)->name;
                                    if ($g->player_id == $a->id) {
                                        $a->goals = $a->goals + 1;
                                    }
                                    if ($g->player_assist_1_id == $a->id OR $g->player_assist_2_id == $a->id) {
                                        $a->assists = $a->assists + 1;
                                    }
                                    $a->points = $a->goals + $a->assists;
                                    if ($g->win_goal == 1 AND $g->player_id == $a->id) {
                                        $a->goalsWin = $a->goalsWin + 1;
                                    }
                                    if ($g->win_bullitt == 1 AND $g->player_id == $a->id) {
                                        $a->bullitsWin = $a->bullitsWin + 1;
                                    }
                                }
                            } //Сезон->Группа

                            foreach ($arrayPlayers[0]->{'group'} as $a) {
                                if ($a->id == $p->id) {
                                    if ($g->player_id == $a->id) {
                                        $a->goals = $a->goals + 1;
                                    }
                                    if ($g->player_assist_1_id == $a->id OR $g->player_assist_2_id == $a->id) {
                                        $a->assists = $a->assists + 1;
                                    }
                                    $a->points = $a->goals + $a->assists;
                                    if ($g->win_goal == 1 AND $g->player_id == $a->id) {
                                        $a->goalsWin = $a->goalsWin + 1;
                                    }
                                    if ($g->win_bullitt == 1 AND $g->player_id == $a->id) {
                                        $a->bullitsWin = $a->bullitsWin + 1;
                                    }
                                }
                            } //Группа

                            foreach ($arrayPlayers[0]->{'total'} as $a) {
                                if ($a->id == $p->id) {
                                    if ($g->player_id == $a->id) {
                                        $a->goals = $a->goals + 1;
                                    }
                                    if ($g->player_assist_1_id == $a->id OR $g->player_assist_2_id == $a->id) {
                                        $a->assists = $a->assists + 1;
                                    }
                                    $a->points = $a->goals + $a->assists;
                                    if ($g->win_goal == 1 AND $g->player_id == $a->id) {
                                        $a->goalsWin = $a->goalsWin + 1;
                                    }
                                    if ($g->win_bullitt == 1 AND $g->player_id == $a->id) {
                                        $a->bullitsWin = $a->bullitsWin + 1;
                                    }
                                }
                            } //Итого
                        }
                    }
                }
            } // Группа

            foreach ($matchesPlayoff as $m) { //summaryPlayoff
                foreach ($teams as $t) { //summaryTeam
                    if ($m->home_id == $t->id OR $m->guest_id == $t->id) {
                        foreach ($arrayTeams[0]->{'seasons'}[0]->{$s->season}[0]->{'playoff'} as $a) {
                            if ($a->id == $t->id) {
                                // Количество игр
                                $a->games = $a->games + 1;
                                // Победы и проигрыши в основное, дополнительное и дополнительное по буллитам
                                if ($m->win_main_time == $a->id) {
                                    $a->winMain = $a->winMain + 1;
                                }
                                if ($m->win_additional_time == $a->id) {
                                    $a->winOvertime = $a->winOvertime + 1;
                                }
                                if ($m->lose_main_time == $a->id) {
                                    $a->loseMain = $a->loseMain + 1;
                                }
                                if ($m->lose_additional_time == $a->id) {
                                    $a->loseOvertime = $a->loseOvertime + 1;
                                }
                                if ($m->win_bullitt == $a->id) {
                                    $a->winBullitt = $a->winBullitt + 1;
                                }
                                if ($m->lose_bullitt == $a->id) {
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
                                $a->points = $a->winMain * 3 + $a->winOvertime * 2 + $a->winBullitt * 2 + $a->loseOvertime + $a->loseBullitt;
                            }
                        }

                        foreach ($arrayTeams[0]->{'playoff'} as $a) {
                            if ($a->id == $t->id) {
                                // Количество игр
                                $a->games = $a->games + 1;
                                // Победы и проигрыши в основное, дополнительное и дополнительное по буллитам
                                if ($m->win_main_time == $a->id) {
                                    $a->winMain = $a->winMain + 1;
                                }
                                if ($m->win_additional_time == $a->id) {
                                    $a->winOvertime = $a->winOvertime + 1;
                                }
                                if ($m->lose_main_time == $a->id) {
                                    $a->loseMain = $a->loseMain + 1;
                                }
                                if ($m->lose_additional_time == $a->id) {
                                    $a->loseOvertime = $a->loseOvertime + 1;
                                }
                                if ($m->win_bullitt == $a->id) {
                                    $a->winBullitt = $a->winBullitt + 1;
                                }
                                if ($m->lose_bullitt == $a->id) {
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
                                $a->points = $a->winMain * 3 + $a->winOvertime * 2 + $a->winBullitt * 2 + $a->loseOvertime + $a->loseBullitt;
                            }
                        }

                        foreach ($arrayTeams[0]->{'total'} as $a) {
                            if ($a->id == $t->id) {
                                // Количество игр
                                $a->games = $a->games + 1;
                                // Победы и проигрыши в основное, дополнительное и дополнительное по буллитам
                                if ($m->win_main_time == $a->id) {
                                    $a->winMain = $a->winMain + 1;
                                }
                                if ($m->win_additional_time == $a->id) {
                                    $a->winOvertime = $a->winOvertime + 1;
                                }
                                if ($m->lose_main_time == $a->id) {
                                    $a->loseMain = $a->loseMain + 1;
                                }
                                if ($m->lose_additional_time == $a->id) {
                                    $a->loseOvertime = $a->loseOvertime + 1;
                                }
                                if ($m->win_bullitt == $a->id) {
                                    $a->winBullitt = $a->winBullitt + 1;
                                }
                                if ($m->lose_bullitt == $a->id) {
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
                                $a->points = $a->winMain * 3 + $a->winOvertime * 2 + $a->winBullitt * 2 + $a->loseOvertime + $a->loseBullitt;
                            }
                        }
                    }
                }

                if ($id != null) { //summaryPlayer
                    foreach ($players as $p) {
                        foreach ($goals as $g) {
                            foreach ($arrayPlayers[0]->{'seasons'}[0]->{$s->season}[0]->{'playoff'} as $a) {
                                if ($a->id == $p->id) {
                                    $a->stage = 'Плейофф';
                                    $a->season = $s->season;
                                    $a->teamId = Team::find($p->current_team)->id;
                                    $a->teamName = Team::find($p->current_team)->name;
                                    if ($g->player_id == $a->id) {
                                        $a->goals = $a->goals + 1;
                                    }
                                    if ($g->player_assist_1_id == $a->id OR $g->player_assist_2_id == $a->id) {
                                        $a->assists = $a->assists + 1;
                                    }
                                    $a->points = $a->goals + $a->assists;
                                    if ($g->win_goal == 1 AND $g->player_id == $a->id) {
                                        $a->goalsWin = $a->goalsWin + 1;
                                    }
                                    if ($g->win_bullitt == 1 AND $g->player_id == $a->id) {
                                        $a->bullitsWin = $a->bullitsWin + 1;
                                    }
                                }
                            }

                            foreach ($arrayPlayers[0]->{'playoff'} as $a) {
                                if ($a->id == $p->id) {
                                    if ($g->player_id == $a->id) {
                                        $a->goals = $a->goals + 1;
                                    }
                                    if ($g->player_assist_1_id == $a->id OR $g->player_assist_2_id == $a->id) {
                                        $a->assists = $a->assists + 1;
                                    }
                                    $a->points = $a->goals + $a->assists;
                                    if ($g->win_goal == 1 AND $g->player_id == $a->id) {
                                        $a->goalsWin = $a->goalsWin + 1;
                                    }
                                    if ($g->win_bullitt == 1 AND $g->player_id == $a->id) {
                                        $a->bullitsWin = $a->bullitsWin + 1;
                                    }
                                }
                            }

                            foreach ($arrayPlayers[0]->{'total'} as $a) {
                                if ($a->id == $p->id) {
                                    if ($g->player_id == $a->id) {
                                        $a->goals = $a->goals + 1;
                                    }
                                    if ($g->player_assist_1_id == $a->id OR $g->player_assist_2_id == $a->id) {
                                        $a->assists = $a->assists + 1;
                                    }
                                    $a->points = $a->goals + $a->assists;
                                    if ($g->win_goal == 1 AND $g->player_id == $a->id) {
                                        $a->goalsWin = $a->goalsWin + 1;
                                    }
                                    if ($g->win_bullitt == 1 AND $g->player_id == $a->id) {
                                        $a->bullitsWin = $a->bullitsWin + 1;
                                    }
                                }
                            }
                        }
                    }
                }
            } // Плейофф

        } //Заполнение по сезонам

        if ($id != null) {
            return $arrayPlayers;
        }
        return $arrayTeams;
    }

    /*
     * Calendar - /calendar/index
     */

    public function scopeCalendar($query, $param) {
        $query->select('match.*', 'home.name as homeName', 'guest.name as guestName', 'home.logo as homeLogo', 'guest.logo as guestLogo',
            'home.city as homeCity', 'guest.city as guestCity')
            ->leftJoin('teams AS home', 'home.id', '=', 'match.home_id')
            ->leftJoin('teams AS guest', 'guest.id', '=', 'match.guest_id')
            ->where('match.status', $param);
    }
}
