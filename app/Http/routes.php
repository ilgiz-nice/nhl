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
/*
 * Календарь/Результат (2)
 */
Route::get('calendar', 'CalendarController@index');
/*
 * Команды (3)
 */
Route::resource('teams', 'TeamsController');
/*
 * Статистика (4)
 */
Route::get('statistics', 'StatisticsController@index');

/*
 * Импорт .xlsx
 */
Route::get('import/match', 'ImportController@match');
Route::get('import/result', 'ImportController@result');
Route::get('import/export', 'ImportController@export');
Route::resource('import', 'ImportController');

/*
 * Результаты матчей
 */
Route::get('games', 'GamesController@index');
/*
 * Турнирная таблица
 */
Route::get('tournament', 'TournamentController@index');
/*
 * Календарь игр
 */
Route::get('calendar_old', 'CalendarController@index');
/*
 * Результаты встреч
 */
Route::get('result', 'ResultController@index');
/*
 * Игроки
 */
Route::get('players', 'PlayersController@index');