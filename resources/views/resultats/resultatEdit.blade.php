@extends('layouts.app')
@section('content')

<h1 class="w50 center txtcenter">Enregistrer un résultat </h1>

<form id="form-resultat" class="form" action="enregistrer-resultat" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="idPartie" value="{{$partie->id}}">

<div id="grid-resultat">

  <div class="joueur">
    <h3>{{$partie->user_1->name}} - {{$partie->deck_1->faction->nom}}</h3>
  </div>

  <div id="infos-resultat">
    <h4>{{$partie->nom}}</h4>

    <div>Mode {{$partie->getMode()}}</div>

    <div class="radio">
      <div>
        <label for="resultat1">Victoire {{$partie->deck_1->faction->nom}}</label>
        <input type="radio" name="resultat" value="1" id="resultat1" required>
      </div>
      <div>
        <label for="resultat2">Match nul</label>
        <input type="radio" name="resultat" value="0" id="resultat2">
      </div>

      <div>
        <label for="resultat3">Victoire {{$partie->deck_2->faction->nom}}</label>
        <input type="radio" name="resultat" value="-1" id="resultat3">
      </div>

      <div>
        <label for="type1">Contrôle des bases</label>
        <input type="radio" name="type" value="controleBase" id="type1" required>
      </div>
      <div>
        <label for="type2">Points</label>
        <input type="radio" name="type" value="points" id="type2">
      </div>
      <div>
        <label for="type3">Abandon</label>
        <input type="radio" name="type" value="abandon" id="type3">
      </div>
    </div>

    <div>
      <label for="tourPartie">Tour</label>
      <input type="number" id="tourPartie" name="tour" value="0" min="0" max="8">
    </div>
  </div>

  <div class="joueur">
    <h3>{{$partie->user_2->name}} - {{$partie->deck_2->faction->nom}}</h3>
  </div>

  </div>

<div class="w50 center txtcenter">
    <button type="submit" class="button card" name="button">Valider</button>
</div>


</form>

@endsection
