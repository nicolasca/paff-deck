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
    $("#creer-deck .nav-faction").click(function() {
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

    // Quand on change la faction, on récupère l'id, et on appelle le controller.
    // Celui ci nous renvoie une vue que l'on insert dans le div faction_show
    $("#factions .nav-faction").click(function() {
        var id_faction = $(this).attr('id');

        // On gère l'opacity du circle et nom de la faction (qui ont des opcacités de base différentes)
        $(".nav-faction").removeClass("dark");
        $(".nav-faction").addClass("clear");
        $(this).addClass("dark");

        $.get("factions/afficherFaction", {
            'id_faction': id_faction
        }, function(data) {
            $("#presentation-univers").hide();
            $("#factionToInclude").html(data);
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
