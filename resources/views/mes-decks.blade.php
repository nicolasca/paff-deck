@extends('layouts.app')
@section('content')
<div>

  <select id="choix_deck">
      <<option selected="true" disabled="disabled">Choix du deck</option>
    @foreach($decks as $deck)
      <option value="{{$deck->id}}">{{$deck->nom}}</option>
    @endforeach
  </select>


  <!-- Cachés par default. Leur visibilité est modifiée par le .js -->
    <a class="button" id="btnModifDeck" style="display:none;">Modifier</a>
    <a class="button" id="btnSupprimerDeck"  style="display:none;">Supprimer</a>
    <a class="button" id="btnAnnulerDeck"  style="display:none;">Annuler</a>

    @if(Session::has('message'))
      <p id="message-session">{{Session::get('message')}}</p>
    @endif

<!-- Div qui contient les decks affichés par un appel Ajax  -->
<div id="deck_show">
</div>


</div>
@endsection
