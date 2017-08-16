@extends('layouts.app')
@section('content')

<h1 class="w50 center txtcenter">Enregistrer un résultat </h1>

<form id="form-resultat" class="form" action="enregistrer-resultat" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="idPartie" value="{{$partie->id}}">

  @include('resultats.resultat-form')

</form>


@endsection
