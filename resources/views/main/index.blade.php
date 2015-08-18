@extends('app')

@section('content')
    <div class="main">
        <div class="widget">
            <div class="tournament">
                <table>
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
                    @foreach($tournament as $i)
                        <tr>
                            <td>{{ $i['name'] }}</td>
                            <td>{{ $i['games'] }}</td>
                            <td>{{ $i['wins'] }}</td>
                            <td>{{ $i['wins_overtime'] }}</td>
                            <td>{{ $i['wins_bullitt'] }}</td>
                            <td>{{ $i['loses_bullitt'] }}</td>
                            <td>{{ $i['loses_overtime'] }}</td>
                            <td>{{ $i['loses'] }}</td>
                            <td>{{ $i['goals'] }}</td>
                            <td>{{ $i['points'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="widget">
            <div class="calendar">
                <table>
                    @foreach($calendar as $i)
                        <tr>
                            <td colspan="3">{{ $i->date }}</td>
                        </tr>
                        <tr>
                            <td>{{ $i->home }}</td>
                            <td>{{ $i->home_goals }} - {{ $i->guest_goals }}</td>
                            <td>{{ $i->guest }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="widget">
            <div class="best">
                <table>
                    <thead>
                    <tr>
                        <th>Номер</th>
                        <th>Игрок</th>
                        <th>Голы</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($best['goal'] as $i)
                        <tr>
                            <td>{{ $i['num'] }}</td>
                            <td>{{ $i['name'] }}</td>
                            <td>{{ $i['goals'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <table>
                    <thead>
                    <tr>
                        <th>Номер</th>
                        <th>Игрок</th>
                        <th>Голы</th>
                        <th>Ассист1</th>
                        <th>Ассист2</th>
                        <th>Очки</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($best['goal_assist'] as $i)
                        <tr>
                            <td>{{ $i['num'] }}</td>
                            <td>{{ $i['name'] }}</td>
                            <td>{{ $i['goals'] }}</td>
                            <td>{{ $i['assist1'] }}</td>
                            <td>{{ $i['assist2'] }}</td>
                            <td>{{ $i['points'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <table>
                    <thead>
                    <tr>
                        <th>Номер</th>
                        <th>Игрок</th>
                        <th>Ассист1</th>
                        <th>Ассист2</th>
                        <th>Очки</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($best['assist'] as $i)
                        <tr>
                            <td>{{ $i['num'] }}</td>
                            <td>{{ $i['name'] }}</td>
                            <td>{{ $i['assist1'] }}</td>
                            <td>{{ $i['assist2'] }}</td>
                            <td>{{ $i['points'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="widget"></div>
    </div>
@stop