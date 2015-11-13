@extends('app')

@section('title')
    Кабинет супервайзера
@stop

@section('content')
    <div class="manager">
        <div class="container_12 menu">
            <div class="grid_12">
                <nav>
                    <ul id="menu">
                        <li><a href="#">Матч</a>
                            <ul>
                                <li class="show" data-tab="match" data-action="create"><a href="#">Создание</a></li>
                                <li class="show" data-tab="match" data-action="export"><a href="#">Экспорт</a></li>
                                <li class="show" data-tab="match" data-action="import"><a href="#">Импорт</a></li>
                                <li class="show" data-tab="match" data-action="settings"><a href="#">Настройки</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Новости</a>
                            <ul>
                                <li class="show" data-tab="news" data-action="create"><a href="#">Создание</a></li>
                                <li class="show" data-tab="news" data-action="settings"><a href="#">Настройки</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Игроки</a>
                            <ul>
                                <li class="show" data-tab="players" data-action="export"><a href="#">Экспорт</a></li>
                                <li class="show" data-tab="players" data-action="import"><a href="#">Импорт</a></li>
                                <li class="show" data-tab="players" data-action="settings"><a href="#">Настройки</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Команды</a>
                            <ul>
                                <li class="show" data-tab="teams" data-action="export"><a href="#">Экспорт</a></li>
                                <li class="show" data-tab="teams" data-action="import"><a href="#">Импорт</a></li>
                                <li class="show" data-tab="teams" data-action="settings"><a href="#">Настройки</a></li>
                                <li class="show" data-tab="teams" data-action="coach"><a href="#">Тренеры</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Сезоны</a>
                            <ul>
                                <li class="show" data-tab="seasons" data-action="create"><a href="#">Создание</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="block">
            <div class="shown match create">
                <div class="container_12">
                    <div class="grid_12">
                        <div class="box">
                            <div class="box_title">Создание матча</div>
                            <div class="box_bot">
                                <div class="maxheight">
                                    {!! Form::open(['route' => 'matches.create', 'method' => 'post']) !!}

                                    {!! Form::label('num', 'Номер игры') !!}
                                    {!! Form::input('number', 'num', $num) !!}

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

                                    {!! Form::label('status', 'Статус матча') !!}
                                    {!! Form::select('status', ['Ожидается' => 'Ожидается', 'Завершен' => 'Завершен']) !!}

                                    {!! Form::submit('Добавить', ['class' => 'btn']) !!}

                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shown match export">
                <div class="container_12">
                    <div class="grid_12 export">
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
                                                    {!! Form::open(['route' => 'matches.export', 'method' => 'post']) !!}

                                                    {!! Form::hidden('action', 'export') !!}
                                                    {!! Form::hidden('id', $m->id) !!}
                                                    {!! Form::hidden('season', $m->season_id) !!}
                                                    {!! Form::hidden('num', $m->num) !!}
                                                    {!! Form::hidden('date', $m->date) !!}
                                                    {!! Form::hidden('status', $m->status) !!}
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
                </div>
            </div>
            <div class="shown match import">
                <div class="container_12">
                    <div class="grid_6 import">
                        <div class="box">
                            <div class="box_title">Импорт</div>
                            <div class="box_bot">
                                <div class="maxheight">
                                    {!! Form::open(['route' => 'matches.result', 'method' => 'post', 'files' => true]) !!}

                                    {!! Form::label('result', 'Результаты матча') !!}
                                    {!! Form::input('file', 'result', '', ['accept' => 'xlsx']) !!}

                                    {!! Form::submit('Отправить', ['class' => 'btn']) !!}

                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shown match settings">
                <div class="container_12">
                    @foreach($matches as $m)
                        <div class="block">
                            <div class="match">{{$m->home}} vs {{$m->guest}}</div>
                            <div class="edit" data-id="{{$m->id}}"><span class="fa fa-pencil"></span></div>
                            <div class="delete"><span class="fa fa-trash-o"></span></div>
                        </div>
                        <div class="subblock" data-id="{{$m->id}}">
                            {!! Form::model($m) !!}

                            {!! Form::label('season_id', 'Сезон') !!}
                            {!! Form::text('season_id') !!}

                            {!! Form::label('num', 'Номер игры') !!}
                            {!! Form::text('num') !!}

                            {!! Form::label('stage', 'Стадия') !!}
                            {!! Form::text('stage') !!}

                            {!! Form::label('status', 'Статус') !!}
                            {!! Form::text('status') !!}

                            {!! Form::label('date', 'Дата') !!}
                            {!! Form::text('date') !!}

                            {!! Form::label('start', 'Время начала') !!}
                            {!! Form::text('start') !!}

                            {!! Form::label('finish', 'Время окончания') !!}
                            {!! Form::text('finish') !!}

                            {!! Form::label('audience', 'Зрители') !!}
                            {!! Form::text('audience') !!}

                            {!! Form::label('home_participants', 'Домашная команда') !!}
                            {!! Form::text('home_participants') !!}

                            {!! Form::label('guest_participants', 'Гостевая команда') !!}
                            {!! Form::text('guest_participants') !!}

                            {!! Form::label('home_goals', 'Голы домашней команды') !!}
                            {!! Form::text('home_goals') !!}

                            {!! Form::label('guest_goals', 'Голы гостевой команды') !!}
                            {!! Form::text('guest_goals') !!}

                            {!! Form::submit('Сохранить', '', array(['class' =>'update'])) !!}

                            {!! Form::close() !!}
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="shown news create">
                <div class="container_12">
                    {!! Form::open(['route' => 'news.create', 'method' => 'post', 'files' => true]) !!}

                    {!! Form::label('title', 'Название:' ) !!}
                    {!! Form::text('title', '', (['required' => true])) !!}

                    {!! Form::label('description', 'Содержание:' ) !!}
                    {!! Form::text('description', '', (['required' => true])) !!}

                    {!! Form::input('file', 'file', '', ['required' => true]) !!}

                    {!! Form::submit( 'Добавить новость') !!}

                    {!! Form::close() !!}
                </div>
            </div>
            <div class="shown news settings">
                @foreach($news as $n)
                    <div id="{{ $n->id }}" class="newsBlock">
                        <div>
                            <label for="">Название</label>
                            <input class="title" type="text" value="{{ $n->title }}">
                        </div>
                        <div>
                            <label for="">Содержание</label>
                            <input class="description" type="text" value="{{ $n->description }}">
                        </div>
                        <input type="radio" class="main" name="{{ Carbon::parse($n->created_at)->format('d-m-y') }}" checked="{{ $n->main }}">Новость дня
                        <input type="radio" class="banner" name="banner" checked="{{ $n->banner }}">Баннер на главной
                    </div>
                @endforeach
                <input type="submit" value="Обновить" class="submitNewsUpdate">
            </div>
            <div class="shown players export">
                {!! Form::open(['route' => 'players.export', 'method' => 'get']) !!}

                {!! Form::submit('Экспорт игроков') !!}

                {!! Form::close() !!}
            </div>
            <div class="shown players import">
                <div class="container_12">
                    {!! Form::open(['route' => 'players.create', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}


                    {!! Form::label('players', 'Импорт команд') !!}
                    {!! Form::input('file', 'players', '', ['accept' => 'xlsx', 'required' => true]) !!}

                    {!! Form::submit('Добавить игроков', ['class' => 'btn']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
            <div class="shown players settings"></div>
            <div class="shown teams export">
                {!! Form::open(['route' => 'teams.export', 'method' => 'get']) !!}

                {!! Form::submit('Экспорт команд') !!}

                {!! Form::close() !!}
            </div>
            <div class="shown teams import">
                <div class="container_12">
                    {!! Form::open(['route' => 'teams.create', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}


                    {!! Form::label('teams', 'Импорт команд') !!}
                    {!! Form::input('file', 'teams', '', ['accept' => 'xlsx', 'required' => true]) !!}

                    {!! Form::submit('Добавить команды', ['class' => 'btn']) !!}

                    {!! Form::close() !!}
                </div>
            </div> <!-- /teams/import -->
            <div class="shown teams coach">
                <div class="container_12">
                    {!! Form::open(['route' => 'coach.create', 'method' => 'post', 'files' => true]) !!}

                    {!! Form::label('name', 'Имя') !!}
                    {!! Form::text('name') !!}

                    {!! Form::label('birthday', 'Дата рождения') !!}
                    {!! Form::input('date', 'birthday', Carbon::now()) !!}

                    {!! Form::label('photo', 'Фото') !!}
                    {!! Form::input('file', 'photo') !!}

                    {!! Form::submit('Добавить тренера') !!}

                    {!! Form::close() !!}
                </div>
            </div> <!-- /teams/coach -->
            <div class="shown teams settings"></div>
            <div class="shown seasons create">
                {!! Form::open(['route' => 'seasons.create', 'method' => 'post']) !!}

                {!! Form::label('season', 'Сезон:') !!}
                {!! Form::text('season', '', ['pattern' => '[0-9]{2}\-[0-9]{2}', 'required' => true, 'placeholder' => '15-16']) !!}

                {!! Form::submit('Добавить сезон') !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop