<div class="inbl carte-main {{Auth::user()->id != $userId ? 'not-visible' : ''}} "
   id="carte_{{$carte->id}}">
  <img src="{{ URL::to('/') }}/images/{{$carte->carte->faction->nom}}/{{$carte->carte->path}}" />
</div>
