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

      $combattants = CombattantsArenes::all()->where("arene", "kalinka");

      return view('priana.classement-arenes')->with("combattants", $combattants);
    }
}
