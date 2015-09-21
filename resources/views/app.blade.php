<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no" />
    <link rel="icon" href="images/favicon.ico">
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/app.css">
</head>
<body class="page1" id="top">
<div class="main">
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
                    <a href="index.html">Marathon</a>
                </div>
                <div class="f_contacts">
                    <a href="#" class="mail_link"><span class="fa fa-envelope"></span> MAIL@DEMOLINK.ORG</a>
                    <div class="f_phone"><span class="fa fa-phone"></span>+1 800 559 6580</div>
                </div>
                <div class="copy">
                    <span>Marathon &copy; 2014 | <a href="#">Privacy Policy</a></span>
                    Website designed by <a href="http://www.templatemonster.com/" rel="nofollow">TemplateMonster.com</a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </footer>
    <script src="js/all.js"></script>
</body>
</html>