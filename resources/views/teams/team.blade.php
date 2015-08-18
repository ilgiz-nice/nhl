@extends('app')

@section('content')
    <div class="team">
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
@stop