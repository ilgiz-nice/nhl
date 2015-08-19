@extends('app')

@section('content')
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
            @foreach($output as $i)
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
@stop