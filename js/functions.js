$(function() {
    /* On utilise une variable globale qui représente un sort de session */
    SESSION = [];


    $( ".draggable" ).draggable({
        containment: "#ecran",
        stop: function(evt, ui) {
            $(this).find(".bouton").addClass("btn-dragged");
        }
    });

    $( ".lancer-modal" ).click(function () {
        // Il faut vérifier que le bouton n'a pas été déplacé
        // https://blog.lysender.com/2010/04/jquery-draggable-prevent-click-event/
        //
        if ($(this).hasClass("btn-dragged"))
            $(this).removeClass("btn-dragged");
        else
            charger_modal(this.id)
    });

    //charger_modal("nourrir");
});


/* *************************************************************************************************** */
/*                  ANIMATIONS ET EFFETS GUI                                                           */
/* *************************************************************************************************** */

function afficher_modal(id, static = false) {
    // Affichage du modal dans le div "ecran". http://stackoverflow.com/a/28386761
    if (static) {
        $(id).modal({
            backdrop: "static",
            keyboard: false
        });
    }
    else {
        $(id).modal();
    }

    $(".modal-backdrop").appendTo('#ecran');
    $("body").removeClass();
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

function activer_drag_drop(draggables, containment, droppables, onDrop = null) {
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
                if (onDrop != null)
                    onDrop();

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

function changer_barre(id, valeur) {
    var stat = $("#" + id);
    stat.find(".barre .couleur").css({width: valeur + "%"});
    stat.find(".titre").html(valeur + "%");

    if (valeur < 30) {
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



/* *************************************************************************************************** */
/*                  FONCTIONS UTILES AJAX                                                              */
/* *************************************************************************************************** */

/* Affichage d'une image pendant qu'on attend une reponse */
function afficher_attente(selector) {
    //$(selector).toggleClass("loading");
}

function cacher_attente(selector) {
    //$(selector).toggleClass("loading");
}

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

            afficher_modal("#modal-action");
        },

        error: function(reponse, code) {
            var modal = $('#modal-action');
            modal.find($('.modal-body')).html("Error : " + code + ". " + reponse);

            afficher_modal("#modal-action");
        }
    });
}

/* Petit outil pour afficher une alerte ou faire appel à une autre fonction qui traitera l'erreur. */
function retourner_erreur(message, callback) {
    if (callback != null)
        callback(message);
    else
        alert("Error : " + message);
}

/* Cette fonction exécute via AJAX une action du contrôleur et renvoie la réponse en format JSON à la fonction
   de callback onSuccess.
   onError est une fonction qui peut être définie pour traiter les cas d'erreur.
   data est utilisé dans le cas d'envoie de formulaires ou d'informations extras au contrôleur.
*/
function appel_ajax(action, onSuccess, onError = null, data = "null") {
    afficher_attente(".modal-content");

    $.ajax({
        url: "controller.php?action=" + action + "&" + data,
        method: "post",

        success: function(reponse, code) {
            cacher_attente(".modal-content");

            try {
                repJSON = JSON.parse(reponse);

                if (repJSON.resultat == "OK")
                    onSuccess(repJSON);
                else
                    retourner_erreur(repJSON.error, onError);
            }
            catch (e) {
                retourner_erreur(reponse, onError);
            }
        },

        error: function(reponse, code) {
            cacher_attente(".modal-content");
            retourner_erreur(code + " => " + reponse, onError);
        }
    });
}

/*
    Code générique pour faire appel à une action en envoyant l'élément sélectionné dans une liste.
    Pour Soigner, Acheter et Nourrir.
*/
function action_element_selecctione(action, onSuccess = null) {
    if (SESSION["elemSelected"] != null) {
        // On cache le popup de l'élément sélectionné
        $("#details-" + SESSION["elemSelected"].id).hide();

        // On fait appel au controlleur
        appel_ajax(action,
            function (reponse, code) {
                // On supprime l'objet de la liste dans le modal
                $("#" + SESSION["elemSelected"].id).remove();
                SESSION["elemSelected"] = null;

                // On fait appel à une fonction en cas de succès
                if (onSuccess != null)
                    onSuccess();
            },
            null,
            "id_objet=" + SESSION["elemSelected"].id
        );
    }
}

/*
    Code générique pour faire appel à une action après d'un drag&drop.
    Pour Habiller, Déshabiller et Modifier environnement (ajouter, supprimer).
*/
function action_drop(action, onSuccess = null) {
    if (SESSION["elemDragged"] != null) {
        // On fait appel au controlleur
        appel_ajax(action,
            function (reponse, code) {
                // On fait appel à une fonction en cas de succès
                if (onSuccess != null)
                    onSuccess();
            },
            null,
            "id_objet=" + SESSION["elemDragged"].id
        );
    }
}



/* *************************************************************************************************** */
/*                  ACTIONS IMPORTANTES DU CONTRÔLEUR                                                  */
/* *************************************************************************************************** */

function login() {
    appel_ajax("login",
        function (reponse) {
            document.location.href = "main.php";
        },
        function (msgError) {
            alert(msgError);
            //document.location.href = "main.php";
        },
        $("#login").serialize()
    );
}

function logout() {
    appel_ajax("logout",
        function (reponse) {
            document.location.href = "index.php";
        }
    );
}

function get_mascotte() {
    appel_ajax("get_mascotte",
        function (reponse) {
            $("#tama").addClass(reponse.mascotte.classe.toLowerCase());
        }
    );
}

function actualiser_etat() {
    appel_ajax("actualiser_etat",
        function (reponse) {
            changer_barre("stat-sante", reponse.sante);
            changer_barre("stat-bonheur", reponse.bonheur);
            changer_barre("stat-faim", reponse.faim);
            changer_barre("stat-maladie", reponse.maladie);
        }
    );
}

function cron_actualiser_etat(temps) {
    setInterval(actualiser_etat, temps);
}

function nourrir() {
    action_element_selectionne("nourrir", actualiser_etat);
}

function soigner() {
    action_element_selectionne("soigner", actualiser_etat);
}

function acheter() {
    action_element_selectionne("acheter");
}

function habiller() {
    action_drop("habiller");
}

function deshabiller() {
    action_drop("deshabiller");
}

function ajouter_decoration() {
    action_drop("ajouter_decoration");
}

function supprimer_decoration() {
    action_drop("supprimer_decoration");
}



