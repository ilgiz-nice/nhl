@extends('app')

@section('content')
    <div class="teams">
        <ul class="list">
            @foreach($teams as $t)
                <li>
                    <div class="team">
                        <div class="img">
                            {!! HTML::image($t->logo) !!}
                        </div>
                        <div class="text">
                            <h5 class="name link" data-href="/teams/{{ $t->id }}">{{ $t->name }}</h5>
                            <p class="city">{{ $t->city }}</p>
                        </div>
                        <div class="hrefs">
                            <a href="/calendar/{{ $t->id }}">Расписание</a>
                            <a href="/stats/{{ $t->id }}">Статистика</a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@stop