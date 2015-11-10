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
                                    Главный тренер
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
                    @foreach($matches as $m)
                        @if(($m->home_id == $id OR $m->guest_id == $id) AND $m->status == 'Ожидается')
                        <li>
                            <div class="home">
                                <div class="img">
                                    {!! HTML::image($m->homeTeam->logo) !!}
                                </div>
                                <div class="info">
                                    <p>{{ $m->homeTeam->name }}</p>
                                    <p>{{ $m->homeTeam->city }}</p>
                                </div>
                            </div>
                            <div class="score">
                                <p>{{ $m->date }}</p>
                                <p>{{ $m->start }}</p>
                            </div>
                            <div class="guest">
                                <div class="info">
                                    <p>{{ $m->guestTeam->name }}</p>
                                    <p>{{ $m->guestTeam->city }}</p>
                                </div>
                                <div class="img">
                                    {!! HTML::image($m->guestTeam->logo) !!}
                                </div>
                            </div>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="played">
                <ul>
                    @foreach($matches as $m)
                        @if(($m->home_id == $id OR $m->guest_id == $id) AND $m->status == 'Завершен')
                        <li>
                            <div class="home">
                                <div class="img">
                                    {!! HTML::image($m->homeTeam->logo) !!}
                                </div>
                                <div class="info">
                                    <p>{{ $m->homeTeam->name }}</p>
                                    <p>{{ $m->homeTeam->city }}</p>
                                </div>
                            </div>
                            <div class="score">
                                <p>{{ $m->home_goals }} - {{ $m->guest_goals }}</p>
                                <p>{{ $m->period_score }}1-1 2-1 2-2</p>
                            </div>
                            <div class="guest">
                                <div class="info">
                                    <p>{{ $m->guestTeam->name }}</p>
                                    <p>{{ $m->guestTeam->city }}</p>
                                </div>
                                <div class="img">
                                    {!! HTML::image($m->guestTeam->logo) !!}
                                </div>
                            </div>
                        </li>
                        @endif
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