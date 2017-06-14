@extends('layouts.app')
@section('content')
<div>


  <form action="jouer-deck/choixDeploiement" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="url" id="url" value="{{ url('/')}}">

  <div id="div-choix-deck" class="mam">
  <select id="choix_deck" name="deck_id">
      <option selected="true" disabled="disabled">Choix du deck</option>
        @if(isset($decksByMode['classique']))
          <optgroup label="{{Config::get('constants.classique')}}">
            @foreach($decksByMode['classique'] as $deck)
              <option value="{{$deck->id}}">{{$deck->nom}}</option>
            @endforeach
          </optgroup>
        @endif
        @if(isset($decksByMode['escarmouche']))
          <optgroup label="{{Config::get('constants.escarmouche')}}">
            @foreach($decksByMode['escarmouche'] as $deck)
              <option value="{{$deck->id}}">{{$deck->nom}}</option>
            @endforeach
          </optgroup>
          @endif
          @if(isset($decksByMode['epique']))
          <optgroup label="{{Config::get('constants.epique')}}">
            @foreach($decksByMode['epique'] as $deck)
              <option value="{{$deck->id}}">{{$deck->nom}}</option>
            @endforeach
          </optgroup>
          @endif

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
