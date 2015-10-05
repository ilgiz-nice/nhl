@extends('app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="matches">
        <div class="match">
            <div class="left">
                <div class="img">
                    {!! HTML::image($match->home_logo) !!}
                </div>
                <div class="team">
                    <h2>{{ $match->home }}</h2>
                </div>
                <div class="city">
                    {{$match->home_city}}
                </div>
            </div> <!-- /left -->
            <div class="center">
                @if($match->status == 'Завершен')
                    <div class="result">
                        @if($match->home_goals > $match->guest_goals)
                            <h3>
                                <b>{{ $match->home_goals }}</b> - {{$match->guest_goals}}
                            </h3>
                        @else
                            <h3>
                                {{ $match->home_goals }} - <b>{{$match->guest_goals}}</b>
                            </h3>
                        @endif
                        <div class="period_score">
                            1-1 1-1 1-1
                        </div>
                    </div>
                @else
                    <div class="time">
                        <span>№{{ $match->num }}</span>
                        <h3><b>{{ Carbon::parse($match->start)->format('H:s') }}</b></h3>
                        <span>{{ $match->date }}</span>
                    </div>
                @endif
            </div> <!-- /center -->
            <div class="right">
                <div class="img">
                    {!! HTML::image($match->guest_logo) !!}
                </div>
                <div class="team">
                    <h2>{{ $match->guest }}</h2>
                </div>
                <div class="city">
                    {{$match->guest_city}}
                </div>
            </div> <!-- /right -->
        </div> <!-- /match -->
        <div class="content">
            <div class="block">
                <h2>Матчи</h2>
                <div class="tabs">
                    <div class="nav">
                        <b class="matchTab active">Превью</b>
                        <b class="matchTab">Очные встречи</b>
                        <b class="matchTab">Составы</b>
                        @if($match->status == 'Завершен')
                            <b class="matchTab">Протокол</b>
                            <b class="matchTab">Резюме</b>
                        @endif
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="header">
                    <div class="left">
                        <div class="team">
                            <div class="img">
                                {!! HTML::image($match->home_logo) !!}
                            </div>
                            <div class="info">
                                <h3>{{ $match->home }}</h3>
                                <span class="city">{{ $match->home_city }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="right">
                        <div class="team">
                            <div class="img">
                                {!! HTML::image($match->guest_logo) !!}
                            </div>
                            <div class="info">
                                <h3>{{ $match->guest }}</h3>
                                <span class="city">{{ $match->guest_city }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="subname">

                    </div>
                </div>
            </div>
        </div> <!-- /content -->
    </div> <!-- /matches -->
    <div class="clear"></div>
@endsection