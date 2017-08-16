<div id="grid-resultat">

  <div class="joueur">
    <h3>{{$resultat->user_1->name}} - {{$resultat->faction_1->nom}}</h3>
  </div>

  <div id="infos-resultat">
    <h4>{{$resultat->nom}}</h4>

    <div>Mode {{$resultat->getMode()}} - Tour {{$resultat->tour}}</div>

    <div class="radio">
      <div>
        <label for="resultat1">Victoire {{$resultat->faction_1->nom}}</label>
        <input type="radio" name="resultat" value="1" id="resultat1" required {{$resultat->resultat == '1' ? 'checked' : '' }}>
      </div>
      <div>
        <label for="resultat2">Match nul</label>
        <input type="radio" name="resultat" value="0" id="resultat2" {{$resultat->resultat == '0' ? 'checked' : '' }}>
      </div>

      <div>
        <label for="resultat3">Victoire {{$resultat->faction_2->nom}}</label>
        <input type="radio" name="resultat" value="-1" id="resultat3" {{$resultat->resultat == '-1' ? 'checked' : '' }}>
      </div>

      <div>
        <label for="type1">Contrôle des bases</label>
        <input type="radio" name="type" value="controleBase" id="type1" {{$resultat->type_victoire == 'controleBase' ? 'checked' : '' }}>
      </div>
      <div>
        <label for="type2">Points</label>
        <input type="radio" name="type" value="points" id="type2" {{$resultat->type_victoire == 'points' ? 'checked' : '' }}>
      </div>
      <div>
        <label for="type3">Abandon</label>
        <input type="radio" name="type" value="abandon" id="type3" {{$resultat->type_victoire == 'abandon' ? 'checked' : '' }}>
      </div>
    </div>
  </div>

  <div class="joueur">
    <h3>{{$resultat->user_2->name}} - {{$resultat->faction_2->nom}}</h3>
  </div>

  </div>

<div class="w50 center txtcenter">
    <button type="submit" class="button card" name="button">Valider</button>
</div>
