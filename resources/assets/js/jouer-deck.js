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

});
