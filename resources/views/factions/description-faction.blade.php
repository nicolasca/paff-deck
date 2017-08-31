
<div id="factionDescription" >


  <div id="image-faction">
    <img src="{{$faction->path_image}}" alt="Image Faction">
  </div>

  <div id="description-faction">
    <h3>{{$faction->nom}}</h3>
    <p>{{$faction->description}}</p>
  </div>

  <div id="description-armee">
    <h3>Description de l'armée</h3>
    <p>{{$faction->description_armee}}</p>
  </div>

  <div id="type-armee">
    <h3>Style de l'armée</h3>
    <p>{{$faction->type_armee}}</p>
  </div>

  <div id="coup-coeur">
    <h3>Coup de coeur</h3>
    <p>{{$faction->coup_coeur}}</p>
  </div>

  <div id="yeux-adversaire">
    <h3>"Voir dans les yeux de l'adversaire...</h3>
    <p>{{$faction->menace_adversaire}}"</p>
  </div>

</div>
