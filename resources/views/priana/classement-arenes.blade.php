<div id="arenes">

  <h1>Les arènes</h1>

  <div class=grid>
    <div>
      <h3 class="w80 center txtcenter">Top 10 Tableau d'Or</h3>
      <div class="classement-liste">
        @foreach($combattantsTableauOr as $combattant)
        <div class="combattant">
          <div class="position">
            <span>{{$loop->index + 1}}.</span>
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

    <div>
    <h3 class="w80 center txtcenter">Top 5 "Ligue de Kalinka" (Sousterre)</h3>
      <div class="classement-liste">
        @foreach($combattantsKalinka as $combattant)
        <div class="combattant">
          <div class="position">
            <span>{{$loop->index + 1}}.</span>
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
  </div>

</div>
