@extends('app')

@section('title')
    Игроки - {{ $player->name }}
@endsection

@section('content')
    <div class="players">
        <div class="player block">
            <div class="left">
                <div class="img">
                    {!! HTML::image('/images/'.$player->photo) !!}
                </div>
                <div class="text">
                    <h3>
                        {{ $player->name }}
                        <span>№ {{ $player->num }}</span>
                    </h3>
                </div>
            </div>
            <div class="right">
                <div class="chart"></div>
            </div>
            <div class="bottom">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>
                            <p>Дата рождения</p>
                            <h4>{{ $player->birthday }}</h4>
                        </td>
                        <td>
                            <p>Рост</p>
                            <h4>{{ $player->height }}</h4>
                        </td>
                        <td>
                            <p>Вес</p>
                            <h4>{{ $player->weight }}</h4>
                        </td>
                        <td>
                            <p>Хват</p>
                            <h4>{{ $player->hand }}</h4>
                        </td>
                        <td>
                            <p>Амплуа</p>
                            <h4>{{ $player->role }}</h4>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="titleTabs">
        <div class="line">
            <h2>Статистика</h2>
            <div class="tabs">
                <div class="padding">
                    <b class="item active">НХЛ</b>
                    <b class="item">Матчи НХЛ</b>
                </div>
            </div>
        </div>
    </div>
    <div class="players">
        <div class="player block">
            <table class="table">
                <thead>
                <tr>
                    <th>Турнир / Команда</th>
                    <th>№</th>
                    <th>И</th>
                    <th>Ш</th>
                    <th>А</th>
                    <th>О</th>
                    <th>+/-</th>
                    <th>Штр</th>
                    <th>ШР</th>
                    <th>ШБ</th>
                    <th>ШМ</th>
                    <th>ШО</th>
                    <th>ШП</th>
                    <th>РБ</th>
                </tr>
                </thead>
                <tbody>
                @foreach($summary[0]->{'seasons'}[0] as $season)
                    @foreach($season as $s)
                        @foreach($s->{'group'} as $g)
                            @if($g->id == $player->id)
                                <tr>
                                    <td colspan="14">{{ $g->stage }} {{ $g->season }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="/stats/team/{{ $g->teamId }}">{{ $g->teamName }}</a>
                                    </td>
                                    <td>{{ $g->num }}</td>
                                    <td>{{ $g->games }}</td>
                                    <td>{{ $g->goals }}</td>
                                    <td>{{ $g->assists }}</td>
                                    <td>{{ $g->points }}</td>
                                    <td>{{ $g->plusMinus }}</td>
                                    <td>{{ $g->penaltyTime }}</td>
                                    <td>{{ $g->goalsEven }}</td>
                                    <td>{{ $g->goalsMore }}</td>
                                    <td>{{ $g->goalsLess }}</td>
                                    <td>{{ $g->goalsOvertime }}</td>
                                    <td>{{ $g->goalsWin }}</td>
                                    <td>{{ $g->bullitsWin }}</td>
                                </tr>
                            @endif
                        @endforeach
                        @foreach($s->playoff as $p)
                            @if($p->id == $player->id)
                                <tr>
                                    <td colspan="14">{{ $p->stage }} {{ $p->season }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="/stats/team/{{ $p->teamId }}">{{ $p->teamName }}</a>
                                    </td>
                                    <td>{{ $p->num }}</td>
                                    <td>{{ $p->games }}</td>
                                    <td>{{ $p->goals }}</td>
                                    <td>{{ $p->assists }}</td>
                                    <td>{{ $p->points }}</td>
                                    <td>{{ $p->plusMinus }}</td>
                                    <td>{{ $p->penaltyTime }}</td>
                                    <td>{{ $p->goalsEven }}</td>
                                    <td>{{ $p->goalsMore }}</td>
                                    <td>{{ $p->goalsLess }}</td>
                                    <td>{{ $p->goalsOvertime }}</td>
                                    <td>{{ $p->goalsWin }}</td>
                                    <td>{{ $p->bullitsWin }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                @endforeach
                <tr>
                    <td>Суммарная статистика НХЛ</td>
                </tr>
                <tr>
                    <td colspan="2">Регулярный чемпионат</td>
                    @foreach($summary[0]->{'group'} as $g)
                        @if($g->id == $player->id)
                        <td>{{ $g->num }}</td>
                        <td>{{ $g->games }}</td>
                        <td>{{ $g->goals }}</td>
                        <td>{{ $g->assists }}</td>
                        <td>{{ $g->points }}</td>
                        <td>{{ $g->plusMinus }}</td>
                        <td>{{ $g->penaltyTime }}</td>
                        <td>{{ $g->goalsEven }}</td>
                        <td>{{ $g->goalsMore }}</td>
                        <td>{{ $g->goalsLess }}</td>
                        <td>{{ $g->goalsOvertime }}</td>
                        <td>{{ $g->goalsWin }}</td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td colspan="2">Плей-офф</td>
                    @foreach($summary[0]->{'playoff'} as $p)
                        @if($p->id == $player->id)
                            <td>{{ $p->num }}</td>
                            <td>{{ $p->games }}</td>
                            <td>{{ $p->goals }}</td>
                            <td>{{ $p->assists }}</td>
                            <td>{{ $p->points }}</td>
                            <td>{{ $p->plusMinus }}</td>
                            <td>{{ $p->penaltyTime }}</td>
                            <td>{{ $p->goalsEven }}</td>
                            <td>{{ $p->goalsMore }}</td>
                            <td>{{ $p->goalsLess }}</td>
                            <td>{{ $p->goalsOvertime }}</td>
                            <td>{{ $p->goalsWin }}</td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td colspan="2">Всего</td>
                    @foreach($summary[0]->{'total'} as $t)
                        @if($t->id == $player->id)
                            <td>{{ $t->num }}</td>
                            <td>{{ $t->games }}</td>
                            <td>{{ $t->goals }}</td>
                            <td>{{ $t->assists }}</td>
                            <td>{{ $t->points }}</td>
                            <td>{{ $t->plusMinus }}</td>
                            <td>{{ $t->penaltyTime }}</td>
                            <td>{{ $t->goalsEven }}</td>
                            <td>{{ $t->goalsMore }}</td>
                            <td>{{ $t->goalsLess }}</td>
                            <td>{{ $t->goalsOvertime }}</td>
                            <td>{{ $t->goalsWin }}</td>
                        @endif
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection