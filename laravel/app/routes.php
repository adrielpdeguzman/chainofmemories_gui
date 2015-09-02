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
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@showWelcome']);
Route::get('login', ['as' => 'auth.login', 'uses' => 'HomeController@login']);
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'HomeController@doLogout']);
Route::post('login', 'HomeController@doLogin');

Route::group(['before' => 'login'], function()
{
    Route::post('logout', 'HomeController@doLogout');

    Route::group(['prefix' => 'journals'], function()
    {
        Route::get('volume/{volume}', ['as' => 'journals.volumes', 'uses' => 'JournalController@showVolume']);
        Route::get('random', ['as' => 'journals.random', 'uses' => 'JournalController@random']);
        Route::get('search', ['as' => 'journals.search', 'uses' => 'JournalController@search']);
        Route::get('searchResults', ['as' => 'journals.doSearch', 'uses' => 'JournalController@doSearch']);
    });
    Route::resource('journals', 'JournalController');
});