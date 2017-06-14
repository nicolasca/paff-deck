@extends('layouts.app')
@section('content')
<div>


  <form action="saveDeck" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="url" id="url" value="{{ url('/')}}">
      <input type="hidden" name="idPartie" value="{{$idPartie}}">

  <div id="div-choix-deck" class="mam">
  <select id="choix_deck" name="deck_id">
      <option selected="true" disabled="disabled">Choix du deck</option>
            @foreach($decksByMode as $deck)
              <option value="{{$deck->id}}">{{$deck->nom}}</option>
            @endforeach
  </select>


  <!-- Cachés par default. Leur visibilité est modifiée par le .js -->
    <input type="submit" class="button" id="btnJouerDeck" style="display:none;" value="Choisir">
  </div>

  </form>

<!-- Div qui contient les decks affichés par un appel Ajax  -->
<div id="deck_show">
</div>


</div>
@endsection
