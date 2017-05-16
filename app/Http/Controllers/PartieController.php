<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use Auth;
use App\Events\PartieCreated;

use App\Partie;


class PartieController extends Controller {


  public function index(Request $request) {
    $partie = "toto";
    return view('parties', compact('partie'));
  }

  public function create() {
    $partie = "partie yeah";

    event(new PartieCreated($partie)); 
    return view('parties', compact('partie'));
  }

}
