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

    // Quand on lance les dés
    $("body").on('click', "#roll-dice", function() {
        var nombreDes = parseInt($("#nombre-des").val());
        var valeurs = "";
        for (i = 0; i < nombreDes; i++) {
            if (i != 0) {
                valeurs += " - "
            }
            var random = Math.floor(Math.random() * 6) + 1;
            valeurs += random + "";
        }

        // Mettre à jour les dés chez tous les joueurs
        var data = {
            valeurs: valeurs,
            type: "dice"
        }
        var url = $("#url").val();
        $.get(url + "/partie/update-infos", {
            data: data
        });
    });

    // Quand un joueur clique sur le bouton "Lancer la partie",
    // on notifie le serveur qui va trigger un Event
    $("#btn-lancer-partie").click(function() {
        $("#btn-lancer-partie").prop("disabled", true);
        $("#btn-lancer-partie").html("Attente du joueur...");
        var idPartie = $("#btn-lancer-partie").data("partieid");
        var url = $("#url").val();
        $.get(url + "/partie/lancer-partie", {
            'idPartie': idPartie
        });
    });

    //MAJ des border selon l'état des cartes

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
            $(dropped).detach().css({
                top: 0,
                left: 0
            }).appendTo(droppedOn);

            // Envoyer la carte id et sa position
            var data = {
                statut: $(this).data("statut"),
                position: $(this).data("position"),
                carteId: ui.draggable.prop("id").split('_')[1]
            }
            var url = $("#url").val();
            $.get(url + "/partie/drag-carte", {
                data: data
            });
        }
    });

    // Quand on change le nombre de tour
    $("body").on("change", "#tour input[type='number']", function() {

      var valeur = $(this).val();
      // Mettre à jour les dés chez tous les joueurs
      var url = $("#url").val();
      $.get(url + "/partie/update-infos", {data:
        {
          type: "tour",
          valeur: valeur}
      });
    });

    // Quand on change le nombre de déploiement d'un joueur, on actualise chez tous les clients
    $("body").on("change", ".ptsDeploiement input[type='number']", function() {
      var valeurJ1 = $("#presentation-joueur-1 .ptsDeploiement input[type='number']").val();
      var valeurJ2 = $("#presentation-joueur-2 .ptsDeploiement input[type='number']").val();
      // Mettre à jour les dés chez tous les joueurs
      var url = $("#url").val();
      $.get(url + "/partie/update-infos", {data:
        {
          type: "depl",
          valeurJ1: valeurJ1,
          valeurJ2: valeurJ2
        }
      });
    });


    $(".bouton-pioche").click(function() {
        var bouton = $(this);
        var userId = $(this).data('userid');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // Recuperer l'id de la zone des cartes main pour ajouter la carte
        var idZoneMain = $(this).parent().parent().attr("id");
        $.post("piocher", {
                _token: CSRF_TOKEN,
                userId: userId,
                id: idZoneMain
            },
            function(data) {

            });
    });

    // Quand on survole une carte, on l'affiche en grand
    $("body").on("mouseover", ".carte-main img", function() {
        var srcImg = $(this).prop("src");
        $("#carte-grand img").prop("src", srcImg)
    });

    // quand on click sur une carte de la zone de jeu, tooltip action s'affiche
    $("body").on("click", "#zone-de-jeu .carte-main img", function() {
        var carte = $(this);
        var offset = $(this).offset();
        $("#tooltip-carte-action").css({
            top: offset.top + 150,
            left: offset.left
        });
        $("#tooltip-carte-action").toggle();

        // Gestion des bordures pour indiquer les zones de combat
        _gestionZonesCombat(carte)
        // Gestion des points de dégats
        _gestionDegats(carte);

        // Sur le click, déplacer une carte dans la défausse
        $("#tooltip-carte-action .bouton-defausse").unbind("click");
        $("#tooltip-carte-action .bouton-defausse").click(function() {
            var flancCombat = $(this).prop("name");
            var parent = $(carte).parent();
            $("#" + $(parent).attr("id")).appendTo("#cartes-defausse");
            $("#" + $(parent).attr("id")).wrap("<div class='zoneDefausse'></div>");
            $("#tooltip-carte-action").toggle();

            // Mettre à jour le statut de la carte, et refresh dans le client
            var data = {
                carteId: $(parent).attr("id").split('_')[1]
            }
            var url = $("#url").val();
            $.get(url + "/partie/deplacer-defausse", {
                data: data
            });
        });

        // Sur le click, afficher l'indicateur de test de moral (opacity)
        $("#tooltip-carte-action .bouton-moral").unbind("click");
        $("#tooltip-carte-action .bouton-moral").click(function() {
            var parent = $(carte).parent();

            // Mettre à jour le statut de la carte, et refresh dans le client
            var data = {
                carteId: $(parent).attr("id"),
                moral: true,
                hasMoral: !$("#" + $(parent).attr("id")).hasClass("testMoral")
            }
            $("#tooltip-carte-action").toggle();
            var url = $("#url").val();
            $.get(url + "/partie/update-etat-carte", {
                data: data
            });
        });

        // Sur le click, afficher l'indicateur du flag (opacity)
        $("#tooltip-carte-action .bouton-flag").unbind("click");
        $("#tooltip-carte-action .bouton-flag").click(function() {
            var parent = $(carte).parent();
            // Mettre à jour le statut de la carte, et refresh dans le client
            var data = {
                carteId: $(parent).attr("id"),
                flag: $("#" + $(parent).attr("id")).find("#flagCarte").hasClass("not-visible")
            }
            $("#tooltip-carte-action").toggle();
            var url = $("#url").val();
            $.get(url + "/partie/update-etat-carte", {
                data: data
            });
        });

        // Sur le click, afficher l'indicateur de fuite (retourner la carte)
        $("#tooltip-carte-action .bouton-fuite").unbind("click");
        $("#tooltip-carte-action .bouton-fuite").click(function() {
          var parent = $(carte).parent();
            // Mettre à jour le statut de la carte, et refresh dans le client
            var data = {
                carteId: $(parent).attr("id"),
                fuite: true,
                isFuite: !$(carte).hasClass("enFuite")
            }
            $("#tooltip-carte-action").toggle();
            var url = $("#url").val();
            $.get(url + "/partie/update-etat-carte", {
                data: data
            });
        });

    });

    // quand on click sur une une zone de jeu, on affiche le tooltip décor
    $("body").on("click", "div.zoneJeu", function() {
        // On affiche la tooltip seulement si pas de carte sur la zone
        if ($(this).children('.carte-main').length == 0) {
            var offset = $(this).offset();
            $("#tooltip-zone-decor").css({
                top: offset.top + 150,
                left: offset.left
            });
            $("#tooltip-zone-decor").toggle();
        }

        var zoneJeu = this;

        // quand on choix un décor, on associe une classe à la zone
        $("#tooltip-zone-decor .bouton-decor").unbind("click");
        $("#tooltip-zone-decor .bouton-decor").click(function() {

            var decor = $(this).prop("name");
            $(zoneJeu).removeClass("foret ruines colline lac decor");
            if (decor != "none") {
                $(zoneJeu).addClass(decor + " decor");
            }
            $("#tooltip-zone-decor").css("display", "none");

            // Mettre à jour le statut de la carte, et refresh dans le client
            var data = {
                'carteId': $(parent).attr("id"),
                'decor': decor,
                'zoneJeu': $(zoneJeu).data("position")
            }
            var url = $("#url").val();
            $.get(url + "/partie/update-zone-decor", {
                data: data
            });
        });
    });


    // Gestion des bordures pour indiquer les zones de combat
    function _gestionZonesCombat(carte) {
        // Gestion des bordures pour indiquer les zones de combat
        // Pour éviter que toutes les cartes reagissent à la même action
        $("#tooltip-carte-action .bouton-combat").unbind("click");
        $("#tooltip-carte-action .bouton-combat").click(function(event) {
            var flancCombat = $(this).prop("name");

            if (flancCombat == "aucun") {
              $(carte).removeClass("front-top");
              $(carte).removeClass("front-bottom");
              $(carte).removeClass("front-right");
              $(carte).removeClass("front-left");
            } else {
              $(carte).addClass("front-" + flancCombat);
            }
            $("#tooltip-carte-action").css("display", "none");

            var parent = $(carte).parent();
            // Mettre à jour le statut de la carte, et refresh dans le client
            var data = {
                carteId: $(parent).attr("id"),
                combat: flancCombat
            }
            var url = $("#url").val();
            $.get(url + "/partie/update-etat-carte", {
                data: data
            });
        });
    }

    // Gestion des points de dégats
    function _gestionDegats(carte) {
        // Gestion des points de dégats
        // Pour éviter que toutes les cartes reagissent à la même action
        $("#tooltip-carte-action .bouton-degats").unbind("click");
        $("#tooltip-carte-action .bouton-degats").click(function(event) {
            var typeDegats = $(this).prop("name");
            var degats = $(carte).data("degats");

            if (typeDegats == "more") {
                degats++;
            } else if (typeDegats == "less") {
                degats--;
            }

            $(carte).data("degats", degats);
            if(degats == 0) {
              $(carte).next("#degats").find("p").html("");
            } else {
              $(carte).next("#degats").find("p").html(degats);
            }

            var parent = $(carte).parent();
            // Mettre à jour le statut de la carte, et refresh dans le client
            var data = {
                carteId: $(parent).attr("id"),
                degats: degats
            }
            var url = $("#url").val();
            $.get(url + "/partie/update-etat-carte", {
                data: data
            });
        });
    }

});
