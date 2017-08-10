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

//------------ MEMBRES ET PROFIL ---------------------
Route::get('/membres', 'MembresController@index');
Route::get('/profil/{id}', 'ProfilController@index');
Route::get('/profil/chart/{userId}', 'ProfilController@getChartData');

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

//-------------GERER UNE PARTIE OU DES PARTIES----------------
Route::get('parties', ['as' => 'parties', 'uses' => 'GererPartieController@index']);
Route::get('creation-partie', function() {
    return View::make('creer-partie');
});
Route::post('creer-partie', 'GererPartieController@create');
Route::get('rejoindre-partie/{id}', 'GererPartieController@rejoindrePartie');
Route::post('partie/choix-deck', 'GererPartieController@choixDeck');
Route::post('partie/saveDeck', 'GererPartieController@saveChoixDeck');
Route::post('partie/choix-deploiement', 'GererPartieController@choixDeploiement');
Route::post('partie/saveChoixDeploiement', 'GererPartieController@saveChoixDeploiement');
Route::get('partie/recap-avant-partie/{id}', 'GererPartieController@recapAvantPartie');
Route::get('partie/lancer-partie', 'GererPartieController@lancerPartie');
Route::post('parties/detruire-partie', 'GererPartieController@detruirePartie');

//-------------JOUER UNE PARTIE----------------
Route::get('partie/zone-jeu', 'JouerPartieController@zoneJeu');
Route::get('partie/piocher-carte-decor', 'JouerPartieController@piocherCarteDecor');
Route::post('partie/piocher', 'JouerPartieController@piocher');
Route::get('partie/drag-carte', 'JouerPartieController@dragCarte');
Route::get('partie/deplacer-defausse', 'JouerPartieController@deplacerDefausse');
Route::get('partie/update-etat-carte', 'JouerPartieController@updateEtatCarte');
Route::get('partie/update-zone-decor', 'JouerPartieController@updateZoneDecor');
Route::get('partie/update-infos', 'JouerPartieController@updateInfos');
Route::get('partie/getCarteView', 'JouerPartieController@getCarteView');
Route::post('partie/update-phase', 'JouerPartieController@updatePhase');

//-----------------RESULTATS -------------------
Route::get('resultats', ['as' => 'resultats', 'uses' => 'ResultatsController@index']);
Route::get('resultats/ajouter-resultat', 'ResultatsController@ajouterResultat');
Route::post('resultats/enregistrer-resultat', 'ResultatsController@create');
