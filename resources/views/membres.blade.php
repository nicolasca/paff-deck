@extends('layouts.app')
@section('content')

<h1 class="w50 center txtcenter">Les 5 PAFFeurs</h1>

<div id="liste-membres" class="w90 center">
  @foreach($users as $user)
  <div class="membre">
    <a href="{{ url('/')}}/profil/{{$user->id}}">{{$user->name}}</a>
  </div>
  @endforeach
</div>

@endsection
