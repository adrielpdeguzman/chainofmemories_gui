<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('login', function()
{
    return 's';
});

Route::get('/', 'HomeController@showWelcome');

Route::group(array('prefix' => 'journals'), function()
{
    Route::get('volume/{volume}', 'JournalController@showVolume');
});
Route::resource('journals', 'JournalController');