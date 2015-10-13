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
                    @foreach($season[0] as $s)
                        //Каждая группа каждый плеофф:
                        <tr>
                            <td colspan="14">{{ $s->stage }} {{ $s->season }}</td>
                        </tr>
                        <tr>
                            <td>
                                <a href="/stats/team/{{ $s->teamId }}">{{ $s->teamName }}</a>
                            </td>
                            <td>{{ $s->num }}</td>
                            <td>{{ $s->games }}</td>
                            <td>{{ $s->goals }}</td>
                            <td>{{ $s->assists }}</td>
                            <td>{{ $s->points }}</td>
                            <td>{{ $s->plusMinus }}</td>
                            <td>{{ $s->penaltyTime }}</td>
                            <td>{{ $s->goalsEven }}</td>
                            <td>{{ $s->goalsMore }}</td>
                            <td>{{ $s->goalsLess }}</td>
                            <td>{{ $s->goalsOvertime }}</td>
                            <td>{{ $s->goalsWin }}</td>
                            <td>{{ $s->bullitsWin }}</td>
                        </tr>
                    @endforeach
                @endforeach
                <tr>
                    <td>Суммарная статистика НХЛ</td>
                </tr>
                <tr>
                    <td colspan="2">Регулярный чемпионат</td>
                    <td>{{ $summaryGroup->num }}</td>
                    <td>{{ $summaryGroup->games }}</td>
                    <td>{{ $summaryGroup->goals }}</td>
                    <td>{{ $summaryGroup->assists }}</td>
                    <td>{{ $summaryGroup->points }}</td>
                    <td>{{ $summaryGroup->plusMinus }}</td>
                    <td>{{ $summaryGroup->penaltyTime }}</td>
                    <td>{{ $summaryGroup->goalsEven }}</td>
                    <td>{{ $summaryGroup->goalsMore }}</td>
                    <td>{{ $summaryGroup->goalsLess }}</td>
                    <td>{{ $summaryGroup->goalsOvertime }}</td>
                    <td>{{ $summaryGroup->goalsWin }}</td>
                </tr>
                <tr>
                    <td colspan="2">Плей-офф</td>
                    <td>{{ $summaryPlayoff->num }}</td>
                    <td>{{ $summaryPlayoff->games }}</td>
                    <td>{{ $summaryPlayoff->goals }}</td>
                    <td>{{ $summaryPlayoff->assists }}</td>
                    <td>{{ $summaryPlayoff->points }}</td>
                    <td>{{ $summaryPlayoff->plusMinus }}</td>
                    <td>{{ $summaryPlayoff->penaltyTime }}</td>
                    <td>{{ $summaryPlayoff->goalsEven }}</td>
                    <td>{{ $summaryPlayoff->goalsMore }}</td>
                    <td>{{ $summaryPlayoff->goalsLess }}</td>
                    <td>{{ $summaryPlayoff->goalsOvertime }}</td>
                    <td>{{ $summaryPlayoff->goalsWin }}</td>
                </tr>
                <tr>
                    <td colspan="2">Всего</td>
                    <td>{{ $summaryTotal->num }}</td>
                    <td>{{ $summaryTotal->games }}</td>
                    <td>{{ $summaryTotal->goals }}</td>
                    <td>{{ $summaryTotal->assists }}</td>
                    <td>{{ $summaryTotal->points }}</td>
                    <td>{{ $summaryTotal->plusMinus }}</td>
                    <td>{{ $summaryTotal->penaltyTime }}</td>
                    <td>{{ $summaryTotal->goalsEven }}</td>
                    <td>{{ $summaryTotal->goalsMore }}</td>
                    <td>{{ $summaryTotal->goalsLess }}</td>
                    <td>{{ $summaryTotal->goalsOvertime }}</td>
                    <td>{{ $summaryTotal->goalsWin }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection