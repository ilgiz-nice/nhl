@extends('app')

@section('title')
    Календарь/Результат
@endsection

@section('content')
    <div class="calendar">
        <div class="block">
            <div class="titleTabs">
                <div class="line">
                    <h2>Матчи</h2>
                </div>
            </div>
        </div>
        <div class="block">
            <h3>Будущие</h3>
            <ul>
                @foreach($notPlayed as $m)
                    <li>
                        <div class="home">
                            <div class="img">
                                {!! HTML::image($m->homeLogo) !!}
                            </div>
                            <div class="info">
                                <h5>{{ $m->homeName }}</h5>
                                <p class="city">{{ $m->homeCity }}</p>
                            </div>
                        </div>
                        <div class="score">
                            <div class="date">{{ Carbon::parse($m->date)->format('d-M') }}</div>
                            <h3>{{ Carbon::parse($m->start)->format('H:i') }}</h3>
                        </div>
                        <div class="guest">
                            <div class="img">
                                {!! HTML::image($m->guestLogo) !!}
                            </div>
                            <div class="info">
                                <h5>{{ $m->guestName }}</h5>
                                <p class="city">{{ $m->guestCity }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="block">
            <h3>Прошедшие</h3>
            <ul>
                @foreach($played as $m)
                    <li>
                        <div class="home">
                            <div class="img">
                                {!! HTML::image($m->homeLogo) !!}
                            </div>
                            <div class="info">
                                <h5>{{ $m->homeName }}</h5>
                                <p class="city">{{ $m->homeCity }}</p>
                            </div>
                        </div>
                        <div class="score">
                            <div class="date">{{ Carbon::parse($m->date)->format('d-M') }}</div>
                            <h3>{{ $m->home_goals }} - {{ $m->guest_goals }}</h3>
                        </div>
                        <div class="guest">
                            <div class="img">
                                {!! HTML::image($m->guestLogo) !!}
                            </div>
                            <div class="info">
                                <h5>{{ $m->guestName }}</h5>
                                <p class="city">{{ $m->guestCity }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@stop