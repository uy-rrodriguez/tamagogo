$(function() {
    /* On utilise une variable globale qui représente un sort de session */
    SESSION = [];


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

    charger_modal("nourrir");
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

function activer_items_selectables(selectables, basePopupID) {
    $( selectables ).focusin(function () {
        // On cache un autre popup, si un élement était déjà sélectionné
        if (SESSION["elemSelected"] != null) {
            $("#" + basePopupID + SESSION["elemSelected"].id).hide();
        }

        // On affiche un popup à côté
        var popup = $("#" + basePopupID + $(this).attr("id"));
        var pos = $(this).position();
        var scrollTop = popup.parent().scrollTop();
        popup.show();
        popup.css({top: pos.top + scrollTop, left: pos.left});

        // Et on stocke l'élement dans la session
        SESSION["elemSelected"] = {id: $(this).attr("id")};
    });

    /*
    $( selectables ).focusout(function () {
        // On cache le popup à côté
        var popup = $("#" + basePopupID + $(this).attr("id"));
        popup.hide();

        // Et on supprime l'élement de la session
        SESSION["elemSelected"] = null;
    });
    */
}

function activer_drag_drop(draggables, containment, droppables) {
    $(function() {
        SESSION["elemDragged"] = null;

        $( draggables ).draggable({
            containment: containment,
            helper: "clone",
            cursor: "move",

            start: function(evt, elem) {
                SESSION["elemDragged"] = $(this);
                $(this).hide(400,
                             function() {
                                 if (SESSION["elemDragged"] == null)
                                     $(this).show();
                             });
            },

            stop: function(evt, elem) {
                SESSION["elemDragged"] = null;
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


/* Fonctions qui font appel a des actions du controlleur */
function appel_ajax(action, onSuccess, onError = null) {
    $.ajax({
        url: "controller.php",
        method: "post",
        data: {action: action},

        success: function(reponse, code) {
            onSuccess(reponse, code);
        },

        error: function(reponse, code) {
            if (onError != null)
                onError(reponse, code);
            else
                alert("Error : " + code + ". " + reponse);
        }
    });
}

function changer_barre(id, valeur) {
    var stat = $("#" + id);
    stat.find(".barre .couleur").css({width: valeur + "%"});

    if (valeur < 20) {
        stat.removeClass("haut moyen");
        stat.addClass("bas");
    }
    else if (valeur < 80) {
        stat.removeClass("haut bas");
        stat.addClass("moyen");
    }
    else {
        stat.removeClass("moyen bas");
        stat.addClass("haut");
    }
}

function actualiser_etat() {
    appel_ajax("get_etat", function (reponse, code) {
        //repJSON = JSON.parse(reponse);
        changer_barre("stat-sante", 15);
        changer_barre("stat-bonheur", 100);
        changer_barre("stat-faim", 80);
        changer_barre("stat-maladie", 50);
    })
}

function nourrir() {
    if (SESSION["elemSelected"] != null) {
        // On cache le popup de l'élément sélectionné
        $("#details-" + SESSION["elemSelected"].id).hide();

        // On fait appel au controlleur
        appel_ajax("nourrir", function (reponse, code) {
            // On supprime la nourriture de la liste dans le modal
            $("#" + SESSION["elemSelected"].id).remove();
            SESSION["elemSelected"] = null;

            // On actualise les barres d'état
            actualiser_etat();
        });
    }
}

function soigner() {
    if (SESSION["elemSelected"] != null) {
        // On cache le popup de l'élément sélectionné
        $("#details-" + SESSION["elemSelected"].id).hide();

        // On fait appel au controlleur
        appel_ajax("soigner", function (reponse, code) {
            // On supprime le médicament de la liste dans le modal
            $("#" + SESSION["elemSelected"].id).remove();
            SESSION["elemSelected"] = null;

            // On actualise les barres d'état
            actualiser_etat();
        });
    }
}



