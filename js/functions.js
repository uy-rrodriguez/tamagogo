$(function() {
    $( ".draggable" ).draggable({
        containment: "#ecran"
    });

    $('.bouton').click(function () {
        charger_modal(this.id)
    });

    charger_modal("marche");
});


/* Cette fonction va chercher via AJAX le contenu à afficher dans le modal
   Le contenu dépendra de l'action réalisé par l'utilisateur.
   Le controleur se charge de renvoyer le bon code.
*/
function charger_modal(nom_action) {
    $.ajax({
        url: "controller.php",
        method: "post",
        dataType: "json",
        data: {action: nom_action}
    })
    .done(function(reponse) {
        var modal = $('#modal-action');

        modal.find($('.modal-title')).html(reponse.titre);
        modal.find($('.modal-body')).html(reponse.contenu);

        $('#modal-action').modal();
        $('.modal-backdrop').appendTo('#ecran');
        $('body').removeClass();
    });

    // Affichage du modal dans le div "ecran"
    //
    // http://stackoverflow.com/a/28386761
    //
}

function activer_drag_drop(draggables, containment, droppables) {
    $(function() {
        elemDragged = null;

        $( draggables ).draggable({
            containment: containment,
            helper: "clone",
            cursor: "move",

            start: function(evt, elem) {
                elemDragged = $(this);
                $(this).hide(400,
                             function() {
                                 if (elemDragged == null)
                                     $(this).show();
                             });
            },

            stop: function(evt, elem) {
                elemDragged = null;
                $(this).show();
            }
        });

        $( droppables ).droppable({
            drop: function(evt, ui) {
                $(this).append(ui.draggable);
                var h = $(this).height();
                $(this).animate({ scrollTop: h }, 50);
            }
        });
    });
}
