@extends('layouts.app')
@section('content')

<div class="center">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <div id="cartes-jeu">
    @include('jouerDeck.cartes-en-jeu')
  </div>


</div>

@endsection
