$(function() {

  // Clic "Utiliser" pour une carte.
  // On met à jour le model $deckEnCours

  $("body").on('click', "button.utiliserCarte", function() {
    var carte_id = $(this).attr("id");
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.post("utiliserCarte", {
      _token: CSRF_TOKEN,
      carteId: carte_id
    }, function(data) {
      $("#cartes-jeu").html(data);

    });
  });

  $("body").on('click', "#piocher-carte", function() {
    $.get("piocher", function(data) {
      $("#cartes-jeu").html(data);
    });
  });

  $("body").on('click', "#roll-dice", function() {
    var nombreDes = parseInt($("#nombre-des").val());
    var valeurs ="";
    for(i=0;i<nombreDes;i++) {
      if(i !=0) {
        valeurs += " - "
      }
      var random = Math.floor(Math.random() * 6) + 1 ;
      valeurs += random+"";
    }

    $("#resultat-roll-dice").html(valeurs);
  });

  // Quand un joueur clique sur le bouton "Lancer la partie",
  // on notifie le serveur qui va trigger un Event
  $("#btn-lancer-partie").click(function() {
    $("#btn-lancer-partie").prop("disabled", true);
    $("#btn-lancer-partie").html("Attente du joueur...");
    var idPartie = $("#btn-lancer-partie").data("partieid");
    var url = $("#url").val();
    $.get(url+"/partie/lancer-partie", {
      'idPartie': idPartie
    });
  });

  var channel = pusher.subscribe('partie-channel');

// -------------------- ZONE DE JEU ------------------------

  // On ecoute l'event pour lancer la partie.
  // Quand les 2 joueurs ont cliqué sur le boutton,
  // on les redirige
  channel.bind('App\\Events\\PartieLancee', function(data) {
    var idPartie = data.idPartie;
    var idUser = data.idUser;
    // Si un des joueurs a déjà rejoint, on redirige vers la zone de jeu
    if(localStorage.getItem("partieLancee"+idPartie)) {
      localStorage.removeItem("partieLancee"+idPartie);
      console.log("Appel zone de jeu");
      var url = $("#url").val();
      window.location = url+'/partie/zone-jeu?idPartie=' + idPartie;
    } else {
      // Sinon on cree l'item en attentant que le 2e joueur rejoint
      localStorage.setItem("partieLancee"+idPartie, idPartie);
    }
  });

  // Les cartes sont draggable
  $(".carte-main").draggable({
    revert: "invalid"
  });

  // Les zones sont droppable
  $(".zoneJeu").droppable({
  accept: ".carte-main",
  drop: function(ev, ui) {

        // Snap la carte dans l'emplacement
        var dropped = ui.draggable;
        var droppedOn = $(this);
        $(dropped).detach().css({top: 0,left: 0}).appendTo(droppedOn);

        // Envoyer la carte id et sa position
        var data = {
          statut: $(this).data("statut"),
          position: $(this).data("position"),
          carteId: ui.draggable.prop("id").split('_')[1]
        }
        var url = $("#url").val();
        $.get(url+"/partie/drag-carte", {data: data});
      }
  });

  channel.bind('App\\Events\\DragCarteZoneJeu', function(data) {
    console.log(data);
    $("#carte_"+data.carteId).appendTo("#position_"+data.position);
  });


  $(".bouton-pioche").click(function() {
    var bouton = $(this);
    var userId = $(this).data('userid');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.post("piocher", {
      _token: CSRF_TOKEN,
      userId: userId
    },
    function(data) {
      bouton.after(data);
      // Les cartes sont draggable
      $(".carte-main").draggable({
        revert: "invalid"
      });
        $("#zone-de-jeu .carte-main img").selectable();
    });
  });

  // Quand on survole une carte, on l'affiche en grand
  $("body").on("mouseover", ".carte-main img", function() {
    var srcImg = $(this).prop("src");
    $("#carte-grand img").prop("src", srcImg)
  });

  // quand on click sur une carte de la zone de jeu
  $("body").on("click", "#zone-de-jeu .carte-main img", function() {
    var carte = $(this);
    var offset = $(this).offset();
    $("#tooltip-carte-action").css({top: offset.top+150, left: offset.left});
    $("#tooltip-carte-action").toggle();

    // Gestion des bordures pour indiquer les zones de combat
    gestionZonesCombat(carte)
    // Gestion des points de dégats
    gestionDegats(carte);

  });

      // Gestion des bordures pour indiquer les zones de combat
  function gestionZonesCombat(carte) {
    // Gestion des bordures pour indiquer les zones de combat
    // Pour éviter que toutes les cartes reagissent à la même action
    $("#tooltip-carte-action .bouton-combat").unbind("click");
    $("#tooltip-carte-action .bouton-combat").click(function(event) {
      var flancCombat = $(this).prop("name");
      $(carte).css("border-"+flancCombat, "3px solid red");
      if(flancCombat=="none") {
        $(carte).css("border", "none");
      }
      $("#tooltip-carte-action").css("display", "none");
    });
  }

  // Gestion des points de dégats
  function gestionDegats(carte) {
    // Gestion des points de dégats
    // Pour éviter que toutes les cartes reagissent à la même action
    $("#tooltip-carte-action .bouton-degats").unbind("click");
    $("#tooltip-carte-action .bouton-degats").click(function(event) {
      var typeDegats = $(this).prop("name");
      var degats = $(carte).data("degats");

      if(typeDegats=="more") {
        degats++;
      } else if (typeDegats == "less") {
        degats--;
      }

      $(carte).data("degats",degats);
      $(carte).next("#degats").find("p").html(degats);
    });
  }

});
