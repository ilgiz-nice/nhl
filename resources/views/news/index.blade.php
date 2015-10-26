@extends('app')

@section('title')
    Новости
@endsection

@section('content')
    <div class="news">
        @foreach($news as $n)
            <div class="block">
                <div class="date">
                    <div class="figure">{{ $n->date }}</div>
                </div>
                <div class="articles">
                    <div class="news">
                        <div class="main">
                            @foreach($n->news as $i)
                                @if($i->main == 1)
                                    <div class="image" style="background: url('{{ $i->photo }}') 50% 50% no-repeat; background-size:cover;"></div>
                                    <a href="/news/{{ $i->id }}">
                                        <h4>
                                            {{ $i->title }}
                                            <i class="fa fa-clock-o"></i><span class="timestamp">{{ Carbon::parse($i->created_at)->format('H:i') }}</span>
                                        </h4>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                        <div class="rest">
                            @foreach($n->news as $i)
                                @if($i->main == 0)
                                    <div class="flex">
                                        <a href="/news/{{ $i->id }}">
                                            <p>
                                                {{ $i->title }}
                                                <i class="fa fa-clock-o"></i><span class="timestamp">{{ Carbon::parse($i->created_at)->format('H:i') }}</span>
                                            </p>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="clear"></div>
    </div>
@endsection