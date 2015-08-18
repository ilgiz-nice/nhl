@extends('app')

@section('content')
    <div class="import">
        <p>Импорт матча</p>
        {!! Form::open(['url' => '/import', 'enctype' => 'multipart/form-data']) !!}

        {!! Form::hidden('action', 'match') !!}

        {!! Form::label('match', 'Матч') !!}
        {!! Form::input('file', 'match', '', ['accept' => 'xlsx']) !!}

        {!! Form::submit() !!}

        {!! Form::close() !!}
        <p>Импорт результата матча</p>
        {!! Form::open(['url' => '/import', 'enctype' => 'multipart/form-data']) !!}

        {!! Form::hidden('action', 'result') !!}

        {!! Form::label('result', 'Результаты матча') !!}
        {!! Form::input('file', 'result', '', ['accept' => 'xlsx']) !!}

        {!! Form::submit() !!}

        {!! Form::close() !!}
        <p>Экспорт матча</p>
        {!! Form::open() !!}

        {!! Form::hidden('action', 'export') !!}

        {!! Form::label('num', 'Номер игры') !!}
        {!! Form::input('number', 'num', '0', ['min' => 0]) !!}

        {!! Form::label('home', 'Домашная команда') !!}
        {!! Form::select('home', $teams) !!}

        {!! Form::label('guest', 'Гостевая команда') !!}
        {!! Form::select('guest', $teams) !!}

        {!! Form::submit('Скачать') !!}

        {!! Form::close() !!}
    </div>
@stop