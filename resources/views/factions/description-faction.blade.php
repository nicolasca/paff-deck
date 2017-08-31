
<div id="factionDescription" >


  <div id="image-faction">
    <img src="{{$faction->path_image}}" alt="Image Faction">
  </div>

  <div id="description-faction">
    <h1>{{$faction->nom}}</h1>
    <p>{{$faction->description}}</p>
  </div>

  <div id="tableau-carac">
    <table>
      <thead>
        <tr>
          <th>Prise en main</th>
          <th>Offensif</th>
          <th>Défensif</th>
          <th>Taille de l'armée</th>
        </tr>
      </thead>
      <tr>
        <td>
          @for ($i = 0; $i < $faction->prise_main; $i++)
            <i class="fa fa-star" aria-hidden="true"></i>
          @endfor
        </td>
        <td>
          @for ($i = 0; $i < $faction->offensif; $i++)
            <i class="fa fa-star" aria-hidden="true"></i>
          @endfor
        </td>
        <td>
          @for ($i = 0; $i < $faction->defensif; $i++)
            <i class="fa fa-star" aria-hidden="true"></i>
          @endfor
        </td>
        <td>
          @for ($i = 0; $i < $faction->taille_armee; $i++)
            <i class="fa fa-star" aria-hidden="true"></i>
          @endfor
        </td>
      </tr>
    </table>
  </div>

  <div id="description-armee">
    <h3>L'armée</h3>
    <p><em>Description</em></p>
    <p>{{$faction->description_armee}}</p>
    <p><em>Style</em></p>
    <p>{{$faction->type_armee}}</p>
  </div>

  <div id="coup-coeur">
    <h3>Coup de coeur</h3>
    <p>{{$faction->coup_coeur}}</p>
  </div>

  <div id="yeux-adversaire">
    <h3>"Voir dans les yeux de l'adversaire...</h3>
    <p>{{$faction->menace_adversaire}}</p>
  </div>

</div>
