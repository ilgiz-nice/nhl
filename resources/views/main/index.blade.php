@extends('app')

@section('title')
    Главная
@stop

@section('content')
    <div class="main">
        <div class="games">
            @foreach($matches as $m)
                @if($m->date < Carbon::now()->format('Y-m-d'))
                    <div class="block link past" data-href="/matches/{{ $m->id }}">
                        <div class="participants">{{ $m->homeTeam->short }} {{ $m->home_goals }}-{{ $m->guest_goals }} {{ $m->guestTeam->short }}</div>
                        <div class="date">{{ Carbon::parse($m->date)->format('d-M') }}</div>
                    </div>
                @endif
                @if($m->date == Carbon::now()->format('Y-m-d'))
                        <div class="block link today" data-href="/matches/{{ $m->id }}">
                            <div class="participants">{{ $m->homeTeam->short }} {{ $m->home_goals }}-{{ $m->guest_goals }} {{ $m->guestTeam->short }}</div>
                            <div class="date">{{ Carbon::parse($m->date)->format('d-M') }}</div>
                        </div>
                @endif
                    @if($m->date > Carbon::now()->format('Y-m-d'))
                        <div class="block link future" data-href="/matches/{{ $m->id }}">
                            <div class="participants">{{ $m->homeTeam->short }} {{ $m->home_goals }}-{{ $m->guest_goals }} {{ $m->guestTeam->short }}</div>
                            <div class="date">{{ Carbon::parse($m->date)->format('d-M') }}</div>
                        </div>
                    @endif
            @endforeach
        </div> <!-- /games -->
        <div class="teaser">
            <div class="main_news" style="background: url('{!! $main_news[0]->photo !!}') 50% 50% no-repeat; background-size:cover;">
                <a href="/news/{{$main_news[0]->id}}">
                    <h3>{{$main_news[0]->title}}</h3>
                    <span class="date">{{ Carbon::parse($main_news[0]->created_at)->format('d-m-y')}}</span>
                </a>
            </div> <!-- /main_news -->
            <div class="tournament">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="team">Команда</th>
                        <th>И</th>
                        <th>В</th>
                        <th>П</th>
                        <th>О</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tournament[0]->total as $t)
                        <tr class="link" data-href="/teams/{{ $t->id }}">
                            <td>{{ $t->name }}</td>
                            <td>{{ $t->games }}</td>
                            <td>{{ $t->winMain + $t->winOvertime + $t->winBullitt}}</td>
                            <td>{{ $t->loseMain + $t->loseOvertime + $t->loseBullitt}}</td>
                            <td>{{ $t->points }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div> <!-- /tournament -->
        </div> <!-- /teaser -->
        <div class="news">
            @foreach($news as $n)
                <div class="mini link" style="background: url('{{$n->photo}}') 50% 50% no-repeat; background-size:cover;" data-href="/news/{{ $n->id }}">
                    <a href="/news/{{ $n->id }}">
                        <p>
                            <b>
                                {{ $n->title }}
                            </b>
                        </p>
                    </a>
                </div>
            @endforeach
        </div> <!-- /news -->
        <div class="clear"></div>
        @if(count($stats) > 0)
        <div class="stats">
            <div class="container_12">
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
        </div> <!-- /stats -->
        @endif
        <div class="clear"></div>
    </div> <!-- /main -->
@stop

@section('scripts')

@stop