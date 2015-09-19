@extends('app')

@section('title')
    Импорт
@stop

@section('content')
    <div class="import-page">
        <div class="container_12">
            <div class="grid_12 match">
                <div class="box">
                    <div class="box_title">Матч</div>
                    <div class="box_bot">
                        <div class="maxheight">
                            {!! Form::open(['url' => '/import']) !!}

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

                            {!! Form::submit('Добавить', ['class' => 'btn']) !!}

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid_6 export">
                <div class="box">
                    <div class="box_title">Экспорт</div>
                    <div class="box_bot">
                        <div class="maxheight">
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
                                            {!! Form::hidden('season', $m->season_id) !!}
                                            {!! Form::hidden('num', $m->num) !!}
                                            {!! Form::hidden('date', $m->date) !!}
                                            {!! Form::hidden('start', $m->start) !!}
                                            {!! Form::hidden('finish', $m->finish) !!}
                                            {!! Form::hidden('home_id', $m->home_id) !!}
                                            {!! Form::hidden('guest_id', $m->guest_id) !!}
                                            {!! Form::hidden('home', $m->home) !!}
                                            {!! Form::hidden('guest', $m->guest) !!}

                                            {!! Form::submit('Скачать', ['class' => 'btn']) !!}

                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid_6 import">
                <div class="box">
                    <div class="box_title">Импорт</div>
                    <div class="box_bot">
                        <div class="maxheight">
                            {!! Form::open(['url' => '/import', 'enctype' => 'multipart/form-data']) !!}

                            {!! Form::hidden('action', 'result') !!}

                            {!! Form::label('result', 'Результаты матча') !!}
                            {!! Form::input('file', 'result', '', ['accept' => 'xlsx']) !!}

                            {!! Form::submit('Отправить', ['class' => 'btn']) !!}

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid_6 teams">
                <div class="box">
                    <div class="box_title">Команды</div>
                    <div class="box_bot">
                        <div class="maxheight">
                            {!! Form::open(['url' => '/import', 'enctype' => 'multipart/form-data']) !!}

                            {!! Form::hidden('action', 'teams') !!}

                            {!! Form::label('result', 'Результаты матча') !!}
                            {!! Form::input('file', 'teams', '', ['accept' => 'xlsx']) !!}

                            {!! Form::submit('Отправить', ['class' => 'btn']) !!}

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid_6 players">
                <div class="box">
                    <div class="box_title">Игроки</div>
                    <div class="box_bot">
                        <div class="maxheight">
                            {!! Form::open(['url' => '/import', 'enctype' => 'multipart/form-data']) !!}

                            {!! Form::hidden('action', 'players') !!}

                            {!! Form::label('result', 'Результаты матча') !!}
                            {!! Form::input('file', 'players', '', ['accept' => 'xlsx']) !!}

                            {!! Form::submit('Отправить', ['class' => 'btn']) !!}

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid_12 seasons">
                <div class="box">
                    <div class="box_title">Сезоны</div>
                    <div class="box_bot">
                        <div class="maxheight">
                            {!! Form::open(['url' => '/import']) !!}

                            {!! Form::hidden('action', 'seasons') !!}

                            {!! Form::input('number', 'year', Carbon::now()->year, ['min' => 2000, 'max' => Carbon::now()->year]) !!}

                            {!! Form::submit('Добавить сезон', ['class' => 'btn']) !!}

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop