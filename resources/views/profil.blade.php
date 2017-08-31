@extends('layouts.app')
@section('content')


<div id="profile-page">

  <input type="hidden" name="url" id="url" value="{{ url('/')}}">

  <div id="profil-user">
    <div id="avatar-user">
      <div>
        <img src="{{ url('/')}}/{{$user->avatar_path}}" alt="">
      </div>

    </div>
    <div id="infos-user" class="section">
      <h3>  {{$user->name}}</h3>
      <p>Inscrit depuis le {{$user->created_at->format('d/m/Y')}}</p>
      <p>Faction du moment: {{$user->faction_moment}}</p>
    </div>

    <div id="infos-decks" class="section">
      <h3>Decks</h3>
      <p>Nombre de decks: {{$nbDecks}}</p>
      <div id="chartContainer"  style="position: relative; height:200; width:400">
        <canvas id="myChart"></canvas>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<script type="application/javascript" src="{{URL::asset('js/profile.js')}}"></script>
@endpush
