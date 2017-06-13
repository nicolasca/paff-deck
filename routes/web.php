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

// --------- MES DECKS --------------
Route::get('mes-decks', [
  'as' => 'mes-decks',
  'uses' => 'MesDecksController@index'
]);
Route::post('mes-decks/update', 'MesDecksController@updateDeck');
Route::get('mes-decks/edit', 'MesDecksController@editDeck');
Route::get('mes-decks/delete', 'MesDecksController@deleteDeck');
Route::get('mes-decks/show', 'MesDecksController@showDeck');

// --------- CREER UN DECK --------------
Route::get('creer-deck', 'CreerDeckController@index');
Route::get('creer-deck/afficherFaction', 'CreerDeckController@afficherFaction');
Route::post('creer-deck/createDeck', 'CreerDeckController@createDeck');

// --------- JOUER UN DECK --------------
Route::get('jouer-deck', 'JouerDeckController@index');
Route::post('jouer-deck/choixDeploiement', 'JouerDeckController@choixDeploiement');
Route::post('jouer-deck/baseJeu', 'JouerDeckController@baseJeu');
Route::post('jouer-deck/utiliserCarte', 'JouerDeckController@utiliserCarte');
Route::get('jouer-deck/piocher', 'JouerDeckController@piocher');

//-------------PARTIE----------------
Route::get('parties', ['as' => 'parties', 'uses' => 'PartieController@index']);
Route::get('creer-partie', 'PartieController@create');
Route::get('rejoindre-partie/{id}', 'PartieController@rejoindrePartie');
