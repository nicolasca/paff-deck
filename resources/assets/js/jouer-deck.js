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

  // On ecoute l'event pour lancer la partie.
  // Quand les 2 joueurs ont cliqué sur le boutton,
  // on les redirige
  var channel = pusher.subscribe('partie-channel');
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

});
