@extends('layouts.app')
@section('content')

<div id="arenes">


<h3>Top 5 "Ligue de Kalinka" (Sousterre)</h3>

<div class="classement-liste">
    @foreach($combattants as $key=>$combattant)
    <div class="combattant">
      <div class="position">
        <span>{{$key + 1}}.</span>
      </div>
      <div>
        <p>{{$combattant->nom}}, {{$combattant->race}}</p>
        <p>Arme : {{$combattant->arme}}</p>
        <p>Localisation actuelle : {{$combattant->localisation}}</p>
      </div>
    </div>
    @endforeach
</div>



</div>

@endsection
