@extends('app')

@section('content')
    <div class="calendar">
        @foreach($result as $game)
            <div class="date">
                {{ $game['date'] }}
            </div>
            <div class="home">
                {{ $game['home'] }}
            </div>
            <div class="result">
                {{ $game['home_goals'] }} - {{ $game['guest_goals'] }}
            </div>
            <div class="guest">
                {{ $game['guest'] }}
            </div>
        @endforeach
    </div>
@stop