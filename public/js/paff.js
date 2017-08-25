$(function() {


    // Positionnement du recap dans le deckEdit.
    // Au départ, posifionnement fixe dans la page. Ensuite suit le scroll.
    $(window).scroll(function() {
        var recap = $("#recap-edit");
        if (recap.length) {
            var scroll = $(window).scrollTop();
            var positionListeCartes = parseInt($("#liste-cartes").offset().top);
            if (scroll >= positionListeCartes) {
                recap.addClass("fixed");
                recap.css("top", 10);
            } else {
                recap.removeClass("fixed");
            }
        }
    });

    // Quand on change le deck, on récupère l'id, et on appelle le controller.
    // Celui ci nous renvoie une vue que l'on insert dans le div deck_show
    $("#choix_deck").change(function() {
        $('#message-session').css('display', 'none');
        afficherDeck();
    });

    // Quand on clique le bouton "Modifier", on affiche le même deck avec
    // le mode "edit"
    $("#btnModifDeck").click(function() {
        $("#deck_show").empty();
        var id_deck = $("#choix_deck").val();
        $.get("mes-decks/edit", {
            'id_deck': id_deck
        }, function(data) {
            $("#deck_show").append(data);
            $("#btnModifDeck").css('display', 'none');
            $("#btnSupprimerDeck").css('display', 'none');
            $("#btnAnnulerDeck").css('display', 'inline');
            miseJourRecapBox();
        });
    });

    // Quand on annule l'edit d'un deck, on affiche le même deck on mode
    // "show"
    $("#btnAnnulerDeck").click(function() {
        afficherDeck();
    });
    // Suppression d'un deck. Confirmation demandée.
    $("#btnSupprimerDeck").click(function() {
        var c = confirm("Voulez vous vraiment supprimer ce deck à tout jamais ? (oui, à tout jamais)");
        if (c == true) {
            $("#deck_show").empty();
            var id_deck = $("#choix_deck").val();
            $.get("mes-decks/delete", {
                'id_deck': id_deck
            }, function(data) {
                location.reload(true);
                $("#btnModifDeck, #btnSupprimerDeck").css('display', 'none');
                $("#btnSupprimerDeck").css('display', 'none');
                $("#btnAnnulerDeck").css('display', 'none');
            });
        }
    });
    // Appel ajax du controller. Celui ci renvoie la vue "show"
    // avec les données du deck. On insère cette vue dans le div
    // qu'on a vidé au préalable.
    function afficherDeck() {
        $("#deck_show").empty();
        var id_deck = $("#choix_deck").val();
        var url = $("#url").val();
        $.get(url + "/mes-decks/show", {
            'id_deck': id_deck
        }, function(data) {
            $("#deck_show").append(data);
            $("#btnModifDeck").css('display', 'inline');
            $("#btnSupprimerDeck").css('display', 'inline');
            $("#btnJouerDeck").css('display', 'inline');
            $("#btnAnnulerDeck").css('display', 'none');
            miseJourRecapBox();
        });
    }


    // Quand on change la faction, on récupère l'id, et on appelle le controller.
    // Celui ci nous renvoie une vue que l'on insert dans le div faction_show
    $(".nav-faction").click(function() {
        var id_faction = $(this).attr('id');

        // On gère l'opacity du circle et nom de la faction (qui ont des opcacités de base différentes)
        $(".nav-faction").removeClass("dark");
        $(".nav-faction").addClass("clear");
        $(this).addClass("dark");

        $.get("creer-deck/afficherFaction", {
            'id_faction': id_faction
        }, function(data) {
            $("#faction_show").html(data);
        });
    });



    //--------------- DECK EDIT ------(on utilise on() car le DOM vient d'une partial view)

    //Toggle afficher/cacher les cartes par type
    $("body").on('click', '.type-carte', function() {
        $(this).next('.liste-cartes').toggle('fast');
        $("i", this).toggleClass("fa-arrow-down fa-arrow-up");
    });


    // Pour le deckEdit, calcul à la volée du nombre de cartes et cout de déploiement
    // Affichage du nom des cartes choisies
    $("body").on("change", ":input[type='number']", function() {
        miseJourRecapBox();
    });

    // Quand on appuie sur la touche "Entrée" dans un input number des decks, on enlève le comportement
    // par default (submit le form), et on MAJ le recap box
    $(window).keydown(function(event) {
        var divDeck = $("#deck_cartes");
        var isInputNumber = event.target.type == "number";

        if (divDeck.length && isInputNumber) {
            if (event.keyCode == 13) {
                event.preventDefault();
                // if input number, on MAJ le recap
                if (event.target.type == "number") {
                    miseJourRecapBox();
                }
                return false;
            }
        }
        return true;
    });

    function miseJourRecapBox() {
        $(".recap-cartes").html("");
        $(".recap-unite").hide();

        var nombreCartes = 0;
        var coutDeploiement = 0;
        var deplacement = 0;
        $(".carte-info").each(function() {
            var nombreCarteElement = parseInt($(this).val()) || $(this).data("nombre") || 0;
            var coutCarteElement = $(this).data("cout");
            var deplacementCarteElement = $(this).data("deplacement");
            nombreCartes += nombreCarteElement;
            coutDeploiement += (nombreCarteElement * coutCarteElement);
            deplacement += (nombreCarteElement * deplacementCarteElement)

            if (nombreCarteElement > 0) {
                var nom = $(this).data("nom");
                var type = $(this).data("type");
                var htmlToInsert = "<p>x" + nombreCarteElement + " " + nom + "</p>";
                $(htmlToInsert).appendTo("#recap-" + type);
                $("#recap-" + type).parent().show();
            }
        });

        $("#points-deploiement").html(coutDeploiement);
        $("#nombre-cartes").html(nombreCartes);
        $("#deplacement-total").html(deplacement);
    }


    //--------------Parties -------------------------------

    // Dans l'écran e l aliste des parties
    $("body").on("click", "#detruire-partie", function() {
        var deletePartie = confirm("Etes vous sûr et certains de vouloir supprimer cette partie à tout jamais," +
            "jusqu'à la fin de la nuit des temps ? Vous êtes sûr ? T'es sûr kikoulol ?")
        if (deletePartie) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var partieId = $(this).data("partieid");
            $.post("parties/detruire-partie", {
                    partieId: partieId,
                    _token: CSRF_TOKEN
                },
                function(data) {
                    var url = $("#url").val();
                    location.reload();
                });
        }
    });

    //---------------Resultats--------------------

    // Dans l'écran de la liste des résultats
    $("body").on("click", "#detruire-resultat", function() {
        var deleteResultat = confirm("Etes vous sûr et certains de vouloir supprimer ce résultat à tout jamais," +
            "jusqu'à la fin de la nuit des temps ? Vous êtes sûr ? T'es sûr kikoulol ?")
        if (deleteResultat) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var resultatId = $(this).data("resultatid");
            console.log(resultatId);
            $.post("resultats/detruire-resultat", {
                    resultatId: resultatId,
                    _token: CSRF_TOKEN
                },
                function(data) {
                    var url = $("#url").val();
                    location.reload();
                });
        }
    });

    $("input[name=resultat]:radio").click(function() {
      console.log($(this).val());
      if($(this).val() == 0) {
        console.log(("passe"));
        $("input[name=type]:radio").prop("checked", false);
      }
    });
});

$(function() {

  var urlPartie = $("#url").val();

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



    //--------------PARTIE ZONE DE JEU---------------------
    //-----------------------------------------------------

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

    //-------PIOCHE DECORS---------
    $("#pioche-carte-decor").click(function() {
      $.ajax({
        url: "piocher-carte-decor",
        type: 'post',
        headers: {
          'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
          'X-Socket-Id': pusher.connection.socket_id
        },
        success: function(data) {
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
      }});
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
        var urlPartie = $("#url").val();
        $.ajax({
          url: urlPartie + "/partie/update-infos",
          type: 'post',
          headers: {
            'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
            'X-Socket-Id': pusher.connection.socket_id
          },
          data: {
            data: data
        },
        success: function(data) {
          $("#historique-des").prepend("<span>"+data.joueur+": "+data.valeurs+"</span>");
        }});
    });

    // Les cartes sont draggable dans la zone de jeu et la defausse
    $("#zone-de-jeu .carte-main, #defausse .carte-main").draggable({
        revert: "invalid",
        start: function(event, ui) {
          // Because bug in droppable ui, we remove the active zone from here
          $(this).parent(".zoneJeu").removeClass("active-zone");
        }
    });
    //Dans la main, les zones sont selectionnables, et on peut poser la carte
    $('body').on("click", ".cartes-main .carte-main, .cartes-deploiement .carte-main", function(){
        $(".cartes-main .carte-main").not(this).removeClass('active');
        $(this).toggleClass("active");
        var carte = $(this);

        // Sur le click, déplacer la carte dans l'emplacement
        $(".zoneJeu").unbind("click");
        $(".zoneJeu").click(function() {
            var position = $(this).data("position");

            // Envoyer la carte id et sa position
            var data = {
                statut: $(this).data("statut"),
                position: $(this).data("position"),
                carteId: $(carte).prop("id").split('_')[1]
            }
            var urlPartie = $("#url").val();
            $.ajax({
              url: urlPartie + "/partie/deployer-carte",
              type: 'post',
              headers: {
                'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
                'X-Socket-Id': pusher.connection.socket_id
              },
              data: {
                  data: data
            }, success: function() {
              // Deplacer la carte dans la zone de jeu
              $("#carte_" + data.carteId).slideUp(500, function() {
                $(this).appendTo("#position_" + data.position).fadeIn(1500);

                // Detacher l'event onclick sur cette carte, et la mettre draggable
                $(this).unbind("click");
                $(".zoneJeu").unbind("click");
                $(this).draggable({
                    revert: "invalid",
                    start: function(event, ui) {
                      // Because bug in droppable ui, we remove the active zone from here
                      $(this).parent(".zoneJeu").removeClass("active-zone");
                    }
                });
                });
            }});

        });
    });

    // Les zones sont droppable
    $(".zoneJeu").droppable({
        // Accepte:
        // - au début une carte décor
        // - une carte uniquement quand la zone est vide
        accept: function(drag) {
          var isACarte = drag.hasClass("carte-main") || drag.hasClass("cartes-decor");
          var hasAlreadyDraggable = $(this).has('.ui-draggable').length;
          return (isACarte & !hasAlreadyDraggable);
        },
        tolerance: "intersect",
        over: function(event, ui) {
            $(this).addClass("active-zone");
        },
        out: function(event, ui) {
            $(this).removeClass("active-zone");
            // Authorize again one card to drop inside this zone
        },
        drop: function(ev, ui) {
            $(this).removeClass("active-zone");
            var dropped = ui.draggable;
            var droppedOn = $(this);

            // ---------Si c'est une carte decor
            if($(dropped).hasClass("cartes-decor")) {

              // MAJ de la zoneJeu avec la carte décor
              var decor = $(dropped).data("decor");
              $(dropped).remove();
              $(this).addClass(decor + " decor");

              // MAJ dans les autres browsers
              var data = {
                  'carteId': $(dropped).attr("id"),
                  'decor': decor,
                  'zoneJeu': $(this).data("position")
              }
              var urlPartie = $("#url").val();
              $.ajax({
                url: urlPartie + "/partie/update-zone-decor",
                type: 'post',
                headers: {
                  'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
                  'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                  data: data
              },
                success: function(data) {
                  $('[data-position=' + data.zoneJeu + ']').removeClass("foret ruines colline lac decor");
                  if (data.decor != "none") {
                      $('[data-position=' + data.zoneJeu + ']').addClass(data.decor + " decor");
                  }
                }});

              // On vérifie si c'est la dernière carte de décor
                var deplJ1 = $("#cartes-decor-J1").children(".cartes-decor").length;
                var deplJ2 = $("#cartes-decor-J2").children(".cartes-decor").length;
                // Dernière carte decor, on met à jour la phase
                if (deplJ1 + deplJ2 == 0) {
                  var urlPartie = $("#url").val();
                  $.ajax({
                    url: urlPartie + "/partie/update-phase",
                    type: 'post',
                    headers: {
                      'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
                      'X-Socket-Id': pusher.connection.socket_id
                    },
                    data: {
                      phase: "deploiement"
                  },
                  success: function(data) {
                    $("#pioche-carte-decor").hide();
                    $("#phase-partie span").html("Déploiement");
                    $("#phase-partie").data("phase", "deploiement");
                  }});
                }
            }
            // --------Si une carte de deck
            else {
              // Snap la carte dans l'emplacement
              $(dropped).detach().css({
                  top: 0,
                  left: 0
              }).appendTo(droppedOn);

              // On vérifie si c'est la dernière carte du déploiement
              if($("#phase-partie").data("phase") == "deploiement") {
                var deplJ1 = $("#cartes-deploiement-1").children(".carte-main").length;
                var deplJ2 = $("#cartes-deploiement-2").children(".carte-main").length;
                if (deplJ1 + deplJ2 == 0) {
                  var urlPartie = $("#url").val();
                  $.ajax({
                    url: urlPartie + "/partie/update-phase",
                    type: 'post',
                    headers: {
                      'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
                      'X-Socket-Id': pusher.connection.socket_id
                    },
                    data: {
                        phase: "combat"
                  },
                  success: function(data) {
                    $("#phase-partie span").html("Combat");
                    $("#phase-partie").data("phase", "combat");
                    $(".cartes-main").removeClass("not-visible");
                  }});

                }
              }
              // Envoyer la carte id et sa position
              var data = {
                  statut: $(this).data("statut"),
                  position: $(this).data("position"),
                  carteId: ui.draggable.prop("id").split('_')[1]
              }
              var urlPartie = $("#url").val();
              $.ajax({
                url: urlPartie + "/partie/drag-carte",
                type: 'post',
                headers: {
                  'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
                  'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                    data: data
              }});

            }
        }
    });

    // Quand on change le nombre de tour
    $("body").on("change", "#tour input[type='number']", function() {

      var valeur = $(this).val();
      var data = {
          type: "tour",
          valeur: valeur
      };
      // Mettre à jour les dés chez tous les joueurs
      $.ajax({
        url: urlPartie + "/partie/update-infos",
        type: 'post',
        headers: {
          'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
          'X-Socket-Id': pusher.connection.socket_id
        },
        data: {
          data: data
      }});
    });

    // Quand on change le nombre de déploiement d'un joueur, on actualise chez tous les clients
    $("body").on("change", ".ptsDeploiement input[type='number']", function() {
      var valeurJ1 = $("#presentation-joueur-1 .ptsDeploiement input[type='number']").val();
      var valeurJ2 = $("#presentation-joueur-2 .ptsDeploiement input[type='number']").val();
      // Mettre à jour les dés chez tous les joueurs
      var data = {
        type: "depl",
        valeurJ1: valeurJ1,
        valeurJ2: valeurJ2
      };
      $.ajax({
        url: urlPartie + "/partie/update-infos",
        type: 'post',
        headers: {
          'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
          'X-Socket-Id': pusher.connection.socket_id
        },
        data: {
            data: data
      }});
    });


    $(".bouton-pioche").click(function() {
        var bouton = $(this);
        var userId = $(this).data('userid');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // Recuperer l'id de la zone des cartes main pour ajouter la carte
        var idZoneMain = $(this).parent().parent().attr("id");
        var data = {
          userId: userId,
          id: idZoneMain
        }
        $.ajax({
          url: "piocher",
          type: 'post',
          headers: {
            'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
            'X-Socket-Id': pusher.connection.socket_id
          },
          data: {
              data: data
        },
        success: function(data) {
          $.get("getCarteView", data, function(view) {
              // Afficher la carte
              $('#' + data["id"]).prepend(view);
              // MAJ cartes restantes
              $("#button1").text("Piocher ("+data.cartesRestantesJ1+")");
              $("#button2").text("Piocher ("+data.cartesRestantesJ2+")");
          });
        }});

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

            $.ajax({
              url: urlPartie + "/partie/deplacer-defausse",
              type: 'post',
              headers: {
                'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
                'X-Socket-Id': pusher.connection.socket_id
              },
              data: {
                  data: data
            }});

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
            $.ajax({
              url: urlPartie + "/partie/update-etat-carte",
              type: 'post',
              headers: {
                'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
                'X-Socket-Id': pusher.connection.socket_id
              },
              data: {
                  data: data
            },
            success: function(data) {
              $("#" + $(parent).attr("id")).toggleClass("testMoral");
            }});
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
            $.ajax({
              url: urlPartie + "/partie/update-etat-carte",
              type: 'post',
              headers: {
                'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
                'X-Socket-Id': pusher.connection.socket_id
              },
              data: {
                  data: data
            },
            success: function(data) {
              $("#" + $(parent).attr("id")).find("#flagCarte").toggleClass("not-visible");
            }});
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
            $.ajax({
              url: urlPartie + "/partie/update-etat-carte",
              type: 'post',
              headers: {
                'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
                'X-Socket-Id': pusher.connection.socket_id
              },
              data: {
                  data: data
            },
            success: function(data) {
              $(carte).toggleClass("enFuite");
            }});
        });

    });

    // Si phase de décor, quand on click sur une une zone de jeu, on affiche le tooltip décor
    if($("#phase-partie").data("phase") == "choix_decor") {
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
              $.ajax({
                url: urlPartie + "/partie/update-zone-decor",
                type: 'post',
                headers: {
                  'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
                  'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                    data: data
              }});
          });
      });

    }


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
              $(carte).toggleClass("front-" + flancCombat);
            }
            $("#tooltip-carte-action").css("display", "none");

            var parent = $(carte).parent();
            // Mettre à jour le statut de la carte, et refresh dans le client
            var data = {
                carteId: $(parent).attr("id"),
                combat: flancCombat
            }
            $.ajax({
              url: urlPartie + "/partie/update-etat-carte",
              type: 'post',
              headers: {
                'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
                'X-Socket-Id': pusher.connection.socket_id
              },
              data: {
                  data: data
            }});
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
            $.ajax({
              url: urlPartie + "/partie/update-etat-carte",
              type: 'post',
              headers: {
                'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content'),
                'X-Socket-Id': pusher.connection.socket_id
              },
              data: {
                  data: data
            }});
        });
    }

});

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
      anime({
        targets: "#carte_" + data.carteId,
        translateX: "-="+($("#carte_" + data.carteId).position().left - $("#position_" + data.position).position().left),
        translateY: "-="+($("#carte_" + data.carteId).position().top - $("#position_" + data.position).position().top),
        duration: 3000,
        easing: 'easeInOutQuad'
        });
  });

  channel.bind('App\\Events\\CarteDeployee', function(data) {
    $("#carte_" + data.carteId).slideUp(500, function() {
      $(this).appendTo("#position_" + data.position).fadeIn(1500);
    });
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
          $(carte).toggleClass("front-" + data.combat);
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
        $("#historique-des").prepend("<span>"+data.joueur+": "+data.valeurs+"</span>");
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

$(function() {

if( $("#profile-page").length) {
  var url = $("#url").val();
  var userId = window.location.href.substring(window.location.href .lastIndexOf('/') + 1);
  $.getJSON(url+"/profil/chart/"+userId, function (result) {

  var ctx = document.getElementById("myChart").getContext('2d');

  var labels = [],data=[], colors = [];
    for (var faction in result ) {
           labels.push(faction);
           data.push(result[faction].length);
           colors.push(_random_rgba(0.6));
    }

  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: labels,
          datasets: [{
              data: data,
              borderWidth: 1,
              backgroundColor: colors
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true,
                      stepSize: 1
                  },
                  scaleLabel: {
                    display: true,
                    labelString: "Nombre de decks"
                  }
              }],
              xAxes: [{
                  ticks: {
                    autoSkip: false
                  }
              }]
          },
          tooltips: {
            enabled: false
          },
          legend: {
            display: false
          }
      }
      });

      });


      function _random_rgba(opacity) {
          var o = Math.round, r = Math.random, s = 255;
          return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + opacity + ')';
      }
    }

});
