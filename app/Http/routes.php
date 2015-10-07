<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
 * Главная (Лого)
 */
Route::get('/', 'MainController@index');
/*
 * Новости (1)
 */
Route::get('news', 'NewsController@index');
Route::get('/news/{{id}}', 'NewsController@show');
Route::post( '/news/create', array(
    'as' => 'news.create',
    'uses' => 'NewsController@create'
) );
/*
 * Календарь/Результат (2)
 */
Route::get('calendar', 'CalendarController@index');
/*
 * Команды (3)
 */
Route::get('/teams', 'TeamsController@index');
Route::get('/teams/{id}', 'TeamsController@show');
Route::post('/teams/create', array(
    'as' => 'teams.create',
    'uses' => 'TeamsController@create'
));
Route::get('/teams/export', array(
    'as' => 'teams.export',
    'uses' => 'TeamsController@export'
));
/*
 * Статистика (4)
 */
Route::get('statistics', 'StatisticsController@index');

/*
 * Регламент (5)
 */
Route::get('regulations', 'RegulationsController@index');
/*
 * Импорт .xlsx
 */
Route::get('import', function() {
    return redirect('manager');
});
Route::resource('manager', 'ManagerController');
/*
 * Игроки
 */
Route::get('/players', 'PlayersController@index');
Route::get('/players/{id}', 'PlayersController@show');
Route::post( '/players/create', array(
    'as' => 'players.create',
    'uses' => 'PlayersController@create'
));
Route::get( '/players/export', array(
    'as' => 'players.export',
    'uses' => 'PlayersController@export'
));
/*
 * Тренеры
 */
Route::post( '/coach/create', array(
    'as' => 'coach.create',
    'uses' => 'CoachController@create'
));
/*
 * Сезоны
 */
Route::post( '/seasons/create', array(
    'as' => 'seasons.create',
    'uses' => 'SeasonsController@create'
));
/*
 * Матчи
 */
Route::get('/matches/{id}', 'MatchesController@show');
Route::post('/matches/create', array(
    'as' => 'matches.create',
    'uses' => 'MatchesController@create'
));
Route::post('/matches/export', array(
    'as' => 'matches.export',
    'uses' => 'MatchesController@export'
));
Route::post('/matches/result', array(
    'as' => 'matches.result',
    'uses' => 'MatchesController@result'
));