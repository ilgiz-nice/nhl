@extends('app')

@section('title')
    Новости
@endsection

@section('content')
    <div class="titleTabs">
        <div class="line">
            <h2>Новости</h2>
        </div>
    </div>
    <div class="news">
        @for ($i = Carbon::parse($last[0]->created_at); $i >= Carbon::parse($first[0]->created_at); $i = $i->subDay())
            <div class="block">
                <div class="date">
                    <div class="figure">{{ $i->format('d-M-y) }}</div>
                </div>
                <div class="articles">
                    <div class="news">
                        <div class="main">
                            @foreach ($news as $n)
                                @if (Carbon::parse($n->created_at) == $i)
                                    123
                                    @if ($n->main == 1)
                                        <div class="image" style="background: url('{{ $n->photo }}') 50% 50% no-repeat; background-size:cover;"></div>
                                        <a href="/news/{{ $n->id }}">
                                            <h4>
                                                {{ $n->title }}
                                                <span class="timestamp">{{ Carbos::parse($n->created_at)->format('H:i') }}</span>
                                            </h4>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        <div class="rest">
                            @foreach ($news as $n)
                                @if (Carbon::parse($n->created_at) == $i)
                                    @if ($n->main != true)
                                        <div class="flex">
                                            <a href="/news/{{ $n->id }}">
                                                <p>
                                                    {{ $n->title }}
                                                    <span class="timestamp">{{ Carbos::parse($n->created_at)->format('H:i') }}</span>
                                                </p>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
@endsection