@extends('app')

@section('title')
    Новости
@stop

@section('content')
    @foreach($news as $n)
        <div>{{$n->title}}</div>
        <div>{{$n->description}}</div>
        <div>{{$n->created_at}}</div>
    @endforeach
@stop