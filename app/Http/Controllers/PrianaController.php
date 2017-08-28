<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\priana\CombattantsArenes;

class PrianaController extends Controller
{

    /**
     * Affiche le classement des arènes
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

      $combattantsKalinka = CombattantsArenes::all()->where("arene", "kalinka");
      $combattantsTableauOr = CombattantsArenes::all()->where("arene", "tableau_or");

      return view('priana.priana')
      ->with("combattantsKalinka", $combattantsKalinka)
      ->with("combattantsTableauOr", $combattantsTableauOr);
    }
}
