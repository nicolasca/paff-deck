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

        if (data.combat == "aucun") {
          $(carte).removeClass("front-top");
          $(carte).removeClass("front-bottom");
          $(carte).removeClass("front-right");
          $(carte).removeClass("front-left");
        } else {
          $(carte).addClass("front-" + data.combat);
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
      // Update flag
      if (data.flag) {
        var parent = $(carte).parent();
        $("#" + $(parent).attr("id")).find("#flagCarte").toggleClass("not-visible");
      }
      // Update fuite
      if (data.fuite) {
          $(carte).toggleClass("enFuite");
      }
  });

  channel.bind('App\\Events\\UpdateInfos', function(data) {
      if(data.type == 'dice') {
        $("#historique-des").prepend("<span>"+data.valeurs+"</span>");
      }
      else if(data.type == 'tour') {
        $("#tour input").val(data.valeur);
      }
      else if(data.type == 'depl') {
        $("#presentation-joueur-1 .ptsDeploiement input[type='number']").val(data.valeurJ1);
        $("#presentation-joueur-2 .ptsDeploiement input[type='number']").val(data.valeurJ2);
      }
      else if (data.type == 'decor') {
        for(let decor of data.decorJ1) {
          $("#cartes-decor-J1").append("<div class='"+decor+" cartes-decor' data-decor='"+decor+"'></div>");
        }
        for(let decor of data.decorJ2) {
          console.log(decor);
          $("#cartes-decor-J2").append("<div class='"+decor+" cartes-decor' data-decor='"+decor+"'></div>");
        }

        $(".cartes-decor").draggable({
            revert: "invalid"
          });
      }

  });

  channel.bind('App\\Events\\UpdateCartePiochee', function(data) {
      $.get("getCarteView", data, function(view) {
          // Afficher la carte
          $('#' + data["id"]).prepend(view);
          $(".carte-main").draggable({
              revert: "invalid",
              start: function(event, ui) {
                // Because bug in droppable ui, we remove the active zone from here
                $(this).parent(".zoneJeu").removeClass("active-zone");
              }
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

  channel.bind('App\\Events\\UpdatePhase', function(phase) {
      if (phase == "deploiement") {
        $("#pioche-carte-decor").hide();
        $("#phase-partie span").html("Déploiement");
        $("#phase-partie").data("phase", "deploiement");
      }
      else if(phase == "combat") {
        $("#phase-partie span").html("Combat");
        $("#phase-partie").data("phase", "combat");
        $(".cartes-main").removeClass("not-visible");
      }
  });


  });
