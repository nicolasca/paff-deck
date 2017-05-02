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

Route::get('/', function ()
    {
        return view('connexion');
    })->middleware('guest');

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index');

Route::get('mes-decks', [
  'as' => 'mes-decks',
  'uses' => 'MesDecksController@index'
]);

Route::post('mes-decks/update', 'MesDecksController@updateDeck');

Route::get('mes-decks/edit', 'MesDecksController@editDeck');

Route::get('mes-decks/delete', 'MesDecksController@deleteDeck');

Route::get('mes-decks/show', 'MesDecksController@showDeck');

Route::get('mes-decks/create', 'MesDecksController@createDeck');
