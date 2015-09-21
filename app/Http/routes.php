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
Route::get('/teams', 'TeamsController@index');
Route::get('/teams/{{id}}', 'TeamsController@show');
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
Route::resource('import', 'ImportController');
/*
 * Игроки
 */
Route::get('/players', 'PlayersController@index');
Route::get('/players/{{id}}', 'PlayersController@show');