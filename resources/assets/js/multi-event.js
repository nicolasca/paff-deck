$(function() {

  var channel = pusher.subscribe('partie-channel');

  // -------------------- ZONE DE JEU ------------------------

  // On ecoute l'event pour lancer la partie.
  // Quand les 2 joueurs ont cliqué sur le boutton,
  // on les redirige
  channel.bind('App\\Events\\PartieLancee', function(data) {
      var idPartie = data.idPartie;
      var idUser = data.idUser;
      // Si un des joueurs a déjà rejoint, on redirige vers la zone de jeu
      if (localStorage.getItem("partieLancee" + idPartie)) {
          localStorage.removeItem("partieLancee" + idPartie);
          var url = $("#url").val();
          window.location = url + '/partie/zone-jeu?idPartie=' + idPartie;
      } else {
          // Sinon on cree l'item en attentant que le 2e joueur rejoint
          localStorage.setItem("partieLancee" + idPartie, idPartie);
      }
  });

  channel.bind('App\\Events\\DragCarteZoneJeu', function(data) {
      $("#carte_" + data.carteId).appendTo("#position_" + data.position);
  });

  channel.bind('App\\Events\\DeplacerCarteDefausse', function(data) {
      $("#carte_" + data.carteId).appendTo("#cartes-defausse");
      $("#carte_" + data.carteId).wrap("<div class='zoneDefausse'></div>");
  });

  // Quand changement de l'état d'une carte (degats, fuite, moral...)
  // on update dans le client
  channel.bind('App\\Events\\UpdateEtatCarte', function(data) {
      var carte = $("#" + data.carteId + " img");

      // Update zones combat
      if (data.combat) {
          $(carte).css("border-" + data.combat, "3px solid red");
          if (data.combat == "aucun") {
              $(carte).css("border", "none");
          }
      }
      // Update degats
      if (data.degats) {
          $(carte).data("degats", data.degats);
          if(data.degats == 0) {
            $(carte).next("#degats").find("p").html("");
          } else {
            $(carte).next("#degats").find("p").html(data.degats);
          }

      }

      // Update moral
      if (data.moral) {
          var parent = $(carte).parent();
          $("#" + $(parent).attr("id")).toggleClass("testMoral");
      }

      // Update moral
      if (data.flag) {
        var parent = $(carte).parent();
        $("#" + $(parent).attr("id")).find("#flagCarte").toggleClass("not-visible");
      }

      // Update fuite
      if (data.fuite) {
          var parent = $(carte).parent();
          $("#" + $(parent).attr("id")).toggleClass("enFuite");
      }
  });

  channel.bind('App\\Events\\UpdateInfos', function(data) {
      if(data.type == 'dice') {
        $("#resultat-roll-dice").html(data.valeurs);
      }
      else if(data.type == 'tour') {
        $("#tour input").val(data.valeur);
      }
      else if(data.type == 'depl') {
        $("#presentation-joueur-1 .ptsDeploiement input[type='number']").val(data.valeurJ1);
        $("#presentation-joueur-2 .ptsDeploiement input[type='number']").val(data.valeurJ2);
      }

  });

  channel.bind('App\\Events\\UpdateCartePiochee', function(data) {
      $.get("getCarteView", data, function(view) {
          // Afficher la carte
          $('#' + data["id"]).prepend(view);
          $(".carte-main").draggable({
              revert: "invalid"
          });
          // MAJ cartes restantes
          $("#button1").text("Piocher ("+data.cartesRestantesJ1+")");
          $("#button2").text("Piocher ("+data.cartesRestantesJ2+")");
      });
  });

  channel.bind('App\\Events\\UpdateZoneDecor', function(data) {
      $('[data-position=' + data.zoneJeu + ']').removeClass("foret ruines colline lac decor");
      if (data.decor != "none") {
          $('[data-position=' + data.zoneJeu + ']').addClass(data.decor + " decor");
      }
  });


  });
