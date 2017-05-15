@extends('layouts.app')
@section('content')

<div class="center">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <div id="generateur-des">
    <p>Générateur de dés</p>
    <select id="nombre-des" name="nombre-des">
      @for ($i = 1; $i < 8; $i++)
      <option value="{{$i}}">{{$i}}</option>
      @endfor
    </select>
    <button id="roll-dice" class="button" type="button" name="roll-dice">Azy !</button>
    <span id="resultat-roll-dice"></span>
    <span id="commentaire-roll-dice"></span>
  </div>

  <div id="cartes-jeu">
    @include('jouerDeck.cartes-en-jeu')
  </div>


</div>

@endsection
