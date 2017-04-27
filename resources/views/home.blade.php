@extends('layouts.app')
@section('content')
<div>
  <div>
    @foreach($decks as $deck)
        <p>{{ $deck->nom }}  -->  {{ $deck->faction->nom }}</p>
        @foreach($deck->cartes as $carte)
        <img src="{{ URL::to('/') }}/images/{{$deck->faction->nom}}/{{$carte->path}}" />
        @endforeach

    @endforeach
  </div>
</div>
@endsection
