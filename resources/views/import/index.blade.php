@extends('app')

@section('content')
    <div class="import">
        <p>Импорт матча</p>
        {!! Form::open(['url' => '/import', 'enctype' => 'multipart/form-data']) !!}

        {!! Form::hidden('action', 'match') !!}

        {!! Form::label('num', 'Номер игры') !!}
        {!! Form::input('number', 'num', 0, ['min' => '0']) !!}

        {!! Form::label('date', 'Дата') !!}
        {!! Form::input('date', 'date') !!}

        {!! Form::label('start', 'Время начала') !!}
        {!! Form::input('time', 'start') !!}

        {!! Form::label('finish', 'Время окончания') !!}
        {!! Form::input('time', 'finish') !!}

        {!! Form::label('home', 'Домашная команда') !!}
        {!! Form::select('home', $teams) !!}

        {!! Form::label('guest', 'Гостевая команда') !!}
        {!! Form::select('guest', $teams) !!}

        {!! Form::submit('Добавить') !!}

        {!! Form::close() !!}
        <hr>
        <p>Импорт результата матча</p>
        {!! Form::open(['url' => '/import', 'enctype' => 'multipart/form-data']) !!}

        {!! Form::hidden('action', 'result') !!}

        {!! Form::label('result', 'Результаты матча') !!}
        {!! Form::input('file', 'result', '', ['accept' => 'xlsx']) !!}

        {!! Form::submit() !!}

        {!! Form::close() !!}
        <hr>
        <p>Экспорт матча</p>
        <table>
            <thead>
            <tr>
                <th>Номер игры</th>
                <th>Дата</th>
                <th>Домашная команда</th>
                <th>Гостевая команда</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($matches as $m)
                <tr>
                    <td>{{ $m->num }}</td>
                    <td>{{ $m->date }}</td>
                    <td>{{ $m->home }}</td>
                    <td>{{ $m->guest }}</td>
                    <td>
                        {!! Form::open() !!}

                        {!! Form::hidden('action', 'export') !!}
                        {!! Form::hidden('id', $m->id) !!}
                        {!! Form::hidden('num', $m->num) !!}
                        {!! Form::hidden('date', $m->date) !!}
                        {!! Form::hidden('start', $m->start) !!}
                        {!! Form::hidden('finish', $m->finish) !!}
                        {!! Form::hidden('home', $m->home_id) !!}
                        {!! Form::hidden('guest', $m->guest_id) !!}
                        {!! Form::hidden('test', $m->stage) !!}

                        {!! Form::submit('Скачать') !!}

                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop