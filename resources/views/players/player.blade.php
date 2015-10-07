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
                @foreach($summary as $s)
                    <tr>
                        <td colspan="14">{{ $s->stage }} {{ $s->season }}</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/stats/team/{{ $s->team_id }}">{{ $s->team }}</a>
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
                <tr>
                    <td>Суммарная статистика НХЛ</td>
                </tr>
                <tr>
                    <td colspan="2">Регулярный чемпионат</td>
                    <td>{{ $summuryGroup->num }}</td>
                    <td>{{ $summuryGroup->games }}</td>
                    <td>{{ $summuryGroup->goals }}</td>
                    <td>{{ $summuryGroup->assists }}</td>
                    <td>{{ $summuryGroup->points }}</td>
                    <td>{{ $summuryGroup->plusMinus }}</td>
                    <td>{{ $summuryGroup->penaltyTime }}</td>
                    <td>{{ $summuryGroup->goalsEven }}</td>
                    <td>{{ $summuryGroup->goalsMore }}</td>
                    <td>{{ $summuryGroup->goalsLess }}</td>
                    <td>{{ $summuryGroup->goalsOvertime }}</td>
                    <td>{{ $summuryGroup->goalsWin }}</td>
                </tr>
                <tr>
                    <td colspan="2">Плей-офф</td>
                    <td>{{ $summuryPlayoff->num }}</td>
                    <td>{{ $summuryPlayoff->games }}</td>
                    <td>{{ $summuryPlayoff->goals }}</td>
                    <td>{{ $summuryPlayoff->assists }}</td>
                    <td>{{ $summuryPlayoff->points }}</td>
                    <td>{{ $summuryPlayoff->plusMinus }}</td>
                    <td>{{ $summuryPlayoff->penaltyTime }}</td>
                    <td>{{ $summuryPlayoff->goalsEven }}</td>
                    <td>{{ $summuryPlayoff->goalsMore }}</td>
                    <td>{{ $summuryPlayoff->goalsLess }}</td>
                    <td>{{ $summuryPlayoff->goalsOvertime }}</td>
                    <td>{{ $summuryPlayoff->goalsWin }}</td>
                </tr>
                <tr>
                    <td colspan="2">Всего</td>
                    <td>{{ $summuryTotal->num }}</td>
                    <td>{{ $summuryTotal->games }}</td>
                    <td>{{ $summuryTotal->goals }}</td>
                    <td>{{ $summuryTotal->assists }}</td>
                    <td>{{ $summuryTotal->points }}</td>
                    <td>{{ $summuryTotal->plusMinus }}</td>
                    <td>{{ $summuryTotal->penaltyTime }}</td>
                    <td>{{ $summuryTotal->goalsEven }}</td>
                    <td>{{ $summuryTotal->goalsMore }}</td>
                    <td>{{ $summuryTotal->goalsLess }}</td>
                    <td>{{ $summuryTotal->goalsOvertime }}</td>
                    <td>{{ $summuryTotal->goalsWin }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection