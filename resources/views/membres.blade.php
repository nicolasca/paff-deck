@extends('layouts.app')
@section('content')

<h1 class="w50 center txtcenter">Les 5 PAFFeurs</h1>

<div id="liste-membres" class="w90 center">
  @foreach($users as $user)
  <div class="membre">
    <a href="{{ url('/')}}/profil/{{$user->id}}">{{$user->name}}</a>
    @if($user->isOnline())
      <i class="fa fa-circle" aria-hidden="true"></i>
    @endif
  </div>
  @endforeach
</div>

@endsection
