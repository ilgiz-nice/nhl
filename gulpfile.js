var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass([
        'app.scss',
        'main.scss',
        'manager.scss',
        'matches.scss',
        'teams.scss',
        'players.scss',
        'calendar.scss',
        'news.scss',
        'stats.scss'
    ]);

     mix.styles([
         'reset.css',
         'font-awesome.css',
         'grid.css',
         'superfish.css',
         'style.css'
     ]);

    mix.scripts([
        'jquery.js',
        'js.js',
        'main.js',
        'manager.js',
        'matches.js'
    ]);
});
