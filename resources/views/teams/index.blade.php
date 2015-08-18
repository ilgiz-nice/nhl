@extends('app')

@section('content')
    <div class="teams">
        @foreach($teams as $team)
            <a href="teams/{{ $team->id }}">
                <div class="block">
                    <div class="logo">
                        {!! HTML::image($team->logo) !!}
                    </div>
                    <div class="name">
                        {{ $team->name }}
                    </div>
                    <div class="description">
                        {{ $team->description }}
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@stop