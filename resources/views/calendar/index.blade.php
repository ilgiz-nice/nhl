@extends('app')

@section('content')
    <div class="calendar">
        @foreach($calendar as $c)
            <div class="link" data-href="/news/{{$c->id}}">
                <div class="date">
                    {{ $c['date'] }}
                </div>
                <div class="home">
                    {{ $c['home'] }}
                </div>
                <div class="result">
                    {{ $c['home_goals'] }} - {{ $c['guest_goals'] }}
                </div>
                <div class="guest">
                    {{ $c['guest'] }}
                </div>
            </div>
        @endforeach
    </div>
@stop