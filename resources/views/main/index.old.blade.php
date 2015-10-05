@extends('app')

@section('content')
    <div class="main">
        <div class="grid_12 games">
            <div class="timeline">
                @foreach($games as $g)
                    <div class="block" data-timeline="{{ $g['id'] }}">
                        <div class="participants">{{ $g['home'] }} {{ $g['home_goals'] }}-{{ $g['guest_goals'] }} {{ $g['guest'] }}</div>
                        <div class="date">{{ $g['date'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container_12">
            <div class="clear"></div>
            <div class="grid_8 tournament">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="team">Команда</th>
                        <th class=cell">И</th>
                        <th class="cell">В</th>
                        <th class="cell">ВО</th>
                        <th class="cell">ВБ</th>
                        <th class="cell">ПБ</th>
                        <th class="cell">ПО</th>
                        <th class="cell">П</th>
                        <th class="goals">Ш</th>
                        <th class="cell">О</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tournament as $t)
                        <tr class="link" data-href="/teams/{{ $t['id'] }}">
                            <td>{{ $t['name'] }}</td>
                            <td>{{ $t['games'] }}</td>
                            <td>{{ $t['wins'] }}</td>
                            <td>{{ $t['wins_overtime'] }}</td>
                            <td>{{ $t['wins_bullitt'] }}</td>
                            <td>{{ $t['loses_bullitt'] }}</td>
                            <td>{{ $t['loses_overtime'] }}</td>
                            <td>{{ $t['loses'] }}</td>
                            <td>{{ $t['goals'] }}</td>
                            <td>{{ $t['points'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="grid_4 news">
                @foreach($news as $n)
                    @if($n->main)
                        <div class="main">
                            <div class="left">
                                <div class="title">{{ $n->title }}</div>
                                <div class="description">{{ $n->description }}</div>
                            </div>
                            <div class="right">
                                {!! HTML::image($n->photo) !!}
                            </div>
                        </div>
                    @else
                        <div class="block">
                            <div class="title link" data-href="/news/{{ $n->id }}">{{ $n->title }}</div><div class="date">{{ $n->created_at }}</div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="grid_12 statistics">
                <div class="grid_6 bombardier">
                    <div class="box">
                        <div class="box_title">Бомбардиры</div>
                        <div class="box_bot">
                            <div class="maxheight">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="num">Номер</th>
                                        <th class="name">Имя</th>
                                        <th class="normal">Голы</th>
                                        <th class="normal">Ассисты</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($stats['goal_assist'] as $s)
                                        <tr class="link" data-href="/players/{{ $s['id'] }}">
                                            <td>{{ $s['num'] }}</td>
                                            <td>{{ $s['name'] }}</td>
                                            <td>{{ $s['goals'] }}</td>
                                            <td>{{ $s['assist1'] + $s['assist2'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid_6 sniper">
                    <div class="box">
                        <div class="box_title">Снайперы</div>
                        <div class="box_bot">
                            <div class="maxheight">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="num">Номер</th>
                                        <th class="name">Имя</th>
                                        <th class="normal">Голы</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($stats['goal'] as $s)
                                        <tr class="link" data-href="/players/{{ $s['id'] }}">
                                            <td>{{ $s['num'] }}</td>
                                            <td>{{ $s['name'] }}</td>
                                            <td>{{ $s['goals'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid_6 assist">
                    <div class="box">
                        <div class="box_title">Ассистенты</div>
                        <div class="box_bot">
                            <div class="maxheight">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="num">Номер</th>
                                        <th class="name">Имя</th>
                                        <th class="normal">Ассисты</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($stats['assist'] as $s)
                                        <tr class="link" data-href="/players/{{ $s['id'] }}">
                                            <td>{{ $s['num'] }}</td>
                                            <td>{{ $s['name'] }}</td>
                                            <td>{{ $s['assist1'] + $s['assist2'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid_6 penalty">
                    <div class="box">
                        <div class="box_title">Штрафы</div>
                        <div class="box_bot">
                            <div class="maxheight">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="num">Номер</th>
                                        <th class="name">Имя</th>
                                        <th class="normal">Голы</th>
                                        <th class="normal">Ассисты</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($stats['goal_assist'] as $s)
                                        <tr class="link" data-href="/players/{{ $s['id'] }}">
                                            <td>{{ $s['num'] }}</td>
                                            <td>{{ $s['name'] }}</td>
                                            <td>{{ $s['goals'] }}</td>
                                            <td>{{ $s['assist1'] + $s['assist2'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid_12 calendar">
                @foreach($calendar as $c)
                    123
                @endforeach
            </div>
            <div class="clear"></div>
        </div>
    </div>
    </div>
@stop