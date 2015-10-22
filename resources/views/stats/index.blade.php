@extends('app')

@section('title')
    Статистика
@endsection

@section('content')
    <div class="stats">
        <div class="titleTabs">
            <div class="line">
                <h2>Статистика</h2>
                <div class="tabs">
                    <div class="padding">
                        <div class="item" data-tab="leaders">Лидеры</div>
                        <div class="item" data-tab="personal">Личная</div>
                        <div class="item active" data-tab="command">Командная</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tabContent">
            <div class="block leaders hidden" data-tab="leaders">1</div>
            <div class="block personal hidden" data-tab="personal">2</div>
            <div class="block command" data-tab="command">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Команда</th>
                        <th>И</th>
                        <th>В</th>
                        <th>ВО</th>
                        <th>ВБ</th>
                        <th>ПБ</th>
                        <th>ПО</th>
                        <th>П</th>
                        <th>Ш</th>
                        <th>О</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tournament as $t)
                        <tr>
                            <td>
                                {!! HTML::image($t->logo) !!}
                                <a href="/teams/{{ $t->id }}">
                                    <span>{{ $t->name }}</span>
                                </a>
                            </td>
                            <td>{{ $t->games }}</td>
                            <td>{{ $t->winMain }}</td>
                            <td>{{ $t->winOvertime }}</td>
                            <td>{{ $t->winBullitt }}</td>
                            <td>{{ $t->loseBullitt }}</td>
                            <td>{{ $t->loseOvertime }}</td>
                            <td>{{ $t->loseMain }}</td>
                            <td>{{ $t->goalsGiven }} - {{ $t->goalsTaken }}</td>
                            <td>{{ $t->points }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="clear"></div>
    </div>
@endsection