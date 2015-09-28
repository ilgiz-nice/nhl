@extends('app')

@section('title')
    Импорт
@stop

@section('content')
    <div class="backend">
        <ul id="menu">
            <li><a href="#">Раздел1</a></li>
            <li><a href="#">Раздел2</a>
                <ul>
                    <li><a href="#">Подраздел1</a></li>
                    <li><a href="#">Подраздел2</a></li>
                    <li><a href="#">Подраздел3</a></li>
                </ul>
            </li>
            <li><a href="#">Раздел2</a>
                <ul>
                    <li><a href="#">Подраздел1</a></li>
                    <li><a href="#">Подраздел2</a></li>
                    <li><a href="#">Подраздел3</a></li>
                    <li><a href="#">Подраздел4</a></li>
                    <li><a href="#">Подраздел5</a></li>
                    <li><a href="#">Подраздел6</a></li>
                    <li><a href="#">Подраздел7</a></li>
                </ul>
            </li>
        </ul>
    </div>
@stop