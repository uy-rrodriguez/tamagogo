$(function() {
    $( ".draggable" ).draggable({
        containment: "#ecran",
        stop: function(evt, ui) {
            $(this).find(".bouton").addClass("btn-dragged");
        }
    });

    $( ".bouton" ).click(function () {
        // Il faut vérifier que le bouton n'a pas été déplacé
        // https://blog.lysender.com/2010/04/jquery-draggable-prevent-click-event/
        //
        if ($(this).hasClass("btn-dragged"))
            $(this).removeClass("btn-dragged");
        else
            charger_modal(this.id)
    });

    /*charger_modal("marche");*/
});


/* Cette fonction va chercher via AJAX le contenu à afficher dans le modal
   Le contenu dépendra de l'action réalisé par l'utilisateur.
   Le controleur se charge de renvoyer le bon code.
*/
function charger_modal(nom_action) {
    $.ajax({
        url: "controller.php",
        method: "post",
        /*dataType: "json",*/
        data: {action: nom_action},

        success: function(reponse, code) {
            var modal = $('#modal-action');

            try {
                repJSON = JSON.parse(reponse);
                modal.find($('.modal-title')).html(repJSON.titre);
                modal.find($('.modal-body')).html(repJSON.contenu);
            }
            catch (e) {
                modal.find($('.modal-body')).html("Error : " + reponse);
            }

            // Affichage du modal dans le div "ecran". http://stackoverflow.com/a/28386761
            $('#modal-action').modal();
            $('.modal-backdrop').appendTo('#ecran');
            $('body').removeClass();
        },

        error: function(reponse, code) {
            var modal = $('#modal-action');
            modal.find($('.modal-body')).html("Error : " + code + ". " + reponse);

            $('#modal-action').modal();
            $('.modal-backdrop').appendTo('#ecran');
            $('body').removeClass();
        }
    });


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
