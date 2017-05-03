@extends('layouts.app')
@section('content')
<div id="dashboard">
  <a class="card button" href="{{ url('/creer-deck') }}">Créer un Deck</a>
  <a class="card button" href="{{ url('/mes-decks') }}">Mes Decks</a>
</div>
@endsection
