@extends('app')

@section('title')
    {{ $team->name }}
@endsection

@section('content')
    <div class="teams">
        <div class="banner" style="background: url('{{ $team->logo }}') 50% 50% no-repeat;">
            <div class="block">
                <div class="img">
                    {!! HTML::image($team->logo) !!}
                </div>
                <div class="name">
                    <h3>{{ $team->name }}</h3>
                    <p>{{ $team->city }}</p>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <p>
                                    Ведущий специалист по связям с общественностью тренеров
                                </p>
                                <h4>
                                    {{ $coach }}
                                </h4>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="info">

                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="calendar">
            <div class="notPlayed">
                <ul>
                    @foreach($notPlayed as $np)
                        <li>
                            <div class="home">
                                <p>{{ $np->home }}</p>
                                <p>{{ $np->home_city }}</p>
                            </div>
                            <div class="score">
                                <p>{{ $np->date }}</p>
                                <p>{{ $np->start }}</p>
                            </div>
                            <div class="guest">
                                <p>{{ $np->guest }}</p>
                                <p>{{ $np->guest_city }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="played">
                <ul>
                    @foreach($played as $p)
                        <li>
                            <div class="home">
                                <p>{{ $p->home }}</p>
                                <p>{{ $p->home_city }}</p>
                            </div>
                            <div class="score">
                                <p>{{ $p->home_goals }} - {{ $p->guest_goals }}</p>
                                <p>{{ $p->period_score }}</p>
                            </div>
                            <div class="guest">
                                <p>{{ $p->guest }}</p>
                                <p>{{ $p->guest_city }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="players">
            <div class="photo">
                {!! HTML::image($team->photo) !!}
                <table class="table">
                    <thead>
                    <tr>
                        <th>Фамилия, Имя</th>
                        <th>Номер</th>
                        <th>Амплуа</th>
                        <th>Дата рождения</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($players as $p)
                        <tr class="link" data-href="/players/{{ $p->id }}">
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->num }}</td>
                            <td>{{ $p->role }}</td>
                            <td>{{ $p->birthday }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection