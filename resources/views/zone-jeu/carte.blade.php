<div class="inbl carte-main {{Auth::user()->id != $userId ? 'not-visible' : ''}} "
   id="carte_{{$carte->id}}">
  <img src="{{ URL::to('/') }}/images/{{$carte->carte->faction->nom}}/{{$carte->carte->path}}" data-degats="0"/>
  <div id="degats">
    <p></p>
  </div>
  <div id="flagCarte" class="not-visible">
  </div>
</div>
