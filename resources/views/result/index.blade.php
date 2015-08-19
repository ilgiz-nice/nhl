@extends('app')

@section('content')
    <div class="result">
        <table>
            <thead>
            <tr>
                <th></th>
                @foreach($array as $team)
                    <th>{{ $team['name'] }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($array as $team)
                <tr>
                    <td>{{ $team['name'] }}</td>
                    @foreach($team['inner'] as $result)
                        <td>{{ $result['score'] }}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop