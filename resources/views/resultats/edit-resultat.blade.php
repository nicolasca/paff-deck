@extends('layouts.app')
@section('content')

<h1 class="w50 center txtcenter">Modifier un résultat </h1>

<form id="form-resultat" class="form" action="maj-resultat" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="resultatId" value="{{$resultat->id}}">

  @include('resultats.resultat-form')

</form>


@endsection
