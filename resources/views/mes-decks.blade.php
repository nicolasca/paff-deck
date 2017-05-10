@extends('layouts.app')
@section('content')
<div id="mes-decks">

  <div id="div-choix-deck" class="mam">
  <select id="choix_deck">
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
    <a class="button" id="btnModifDeck" style="display:none;">Modifier</a>
    <a class="button" id="btnSupprimerDeck"  style="display:none;">Supprimer</a>
    <a class="button" id="btnAnnulerDeck"  style="display:none;">Annuler</a>
  </div>

    @if(Session::has('message'))
      <p id="message-session">{{Session::get('message')}}</p>
    @endif

<!-- Div qui contient les decks affichés par un appel Ajax  -->
<div id="deck_show">
</div>


</div>
@endsection
