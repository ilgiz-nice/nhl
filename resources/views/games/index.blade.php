@extends('app')

@section('content')
    <div class="games">
        <table>
            <thead>
            <tr>
                <th>Номер игры</th>
                <th>Дата начала</th>
                <th>Время начала</th>
                <th>Стадия</th>
                <th>Хозяева</th>
                <th>Гости</th>
                <th>Результат</th>
            </tr>
            </thead>
            <tbody>
            @foreach($games as $game)
                <tr>
                    <th>{{ $game->num }}</th>
                    <th>{{ $game->date }}</th>
                    <th>{{ $game->start }}</th>
                    <th>{{ $game->stage }}</th>
                    <th>{{ $game->home }}</th>
                    <th>{{ $game->guest }}</th>
                    <th>{{ $game->status }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop