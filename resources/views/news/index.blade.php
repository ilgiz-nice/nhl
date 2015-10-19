@extends('app')

@section('title')
    Новости
@stop

@section('content')
    <div class="titleTabs">
        <div class="line">
            <h2>Новости</h2>
        </div>
    </div>
    @for($i = Carbon::parse($last[0]->created_at); $i <= Carbon::parse($first[0]->created_at); $i = $i->subMinutes(1))
        //
    @endfor
@stop