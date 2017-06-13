@extends('layouts.app')
@section('content')
<div>


  <form action="jouer-deck/choixDeploiement" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

  <div id="div-choix-deck" class="mam">
  <select id="choix_deck" name="deck_id">
      <option selected="true" disabled="disabled">Choix du deck</option>
            @foreach($decksByMode['escarmouche'] as $deck)
              <option value="{{$deck->id}}">{{$deck->nom}}</option>

  </select>


  <!-- Cachés par default. Leur visibilité est modifiée par le .js -->
    <input type="submit" class="button" id="btnJouerDeck" style="display:none;" value="Utiliser">
  </div>

  </form>

<!-- Div qui contient les decks affichés par un appel Ajax  -->
<div id="deck_show">
</div>


</div>
@endsection
