$(function() {


  // Positionnement du recap dans le deckEdit.
  // Au départ, posifionnement fixe dans la page. Ensuite suit le scroll.
    $(window).scroll(function() {
      var recap = $(".recap-edit");
      if(recap.length) {
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
                console.log(data)
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
        $.get("mes-decks/show", {
            'id_deck': id_deck
        }, function(data) {
            $("#deck_show").append(data);
            $("#btnModifDeck").css('display', 'inline');
            $("#btnSupprimerDeck").css('display', 'inline');
            $("#btnAnnulerDeck").css('display', 'none');
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
    $("body").on("change", ":input[type='number']", function() {
        var nombreCartes = 0;
        var coutDeploiement = 0;
        $(":input[type='number']").each(function() {
            var nombreCarteElement = parseInt($(this).val());
            var coutCarteElement = $(this).data("cout");
            nombreCartes += nombreCarteElement;
            coutDeploiement += (nombreCarteElement * coutCarteElement);
        });
        $("#points-deploiement").html(coutDeploiement);
        $("#nombre-cartes").html(nombreCartes);
    });

});
