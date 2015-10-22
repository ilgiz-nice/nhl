<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no" />
    <link rel="icon" href="images/favicon.ico">
    <link rel="shortcut icon" href="images/favicon.ico" />
    {!! HTML::style('css/all.css') !!}
    {!! HTML::style('css/app.css') !!}
</head>
<body class="page1" id="top">
    <!--==============================header=================================-->
    <header>
        <div class="container_12">
            <div class="grid_12">
                <div class="menu_block">
                    <nav class="horizontal-nav full-width horizontalNav-notprocessed">
                        <ul class="sf-menu">
                            <li class="@yield('class')"><a href="/">Главная</a></li>
                            <li><a href="/news">Новости</a></li>
                            <li><a href="/calendar">Календарь/Результат</a></li>
                            <li><a href="/statistics">Статистика</a></li>
                            <li><a href="/teams">Команды</a></li>
                            <li><a href="/regulations">Регламент</a></li>
                        </ul>
                    </nav>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </header>

    @yield('content')

    <footer>
        <div class="container_12">
            <div class="grid_12">
                <div class="f_logo">
                    <a href="index.html">Ночная хоккейная лига</a>
                </div>
                <div class="f_contacts">
                    <a href="#" class="mail_link"><span class="fa fa-envelope"></span> mail@nhl16.ru</a>
                    <div class="f_phone"><span class="fa fa-phone"></span>+7 (927) 461-66-11</div>
                </div>
                <div class="copy">
                    Сайт создан интернет-агенством <a href="http://www.mak-web.ru/" rel="nofollow">МАК-ВЕБ</a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </footer>
    {!! HTML::script('js/all.js') !!}
</body>
</html>