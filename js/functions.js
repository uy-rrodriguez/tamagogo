$(function() {
    $( ".draggable" ).draggable();

    $('.bouton').click(function () {
        charger_modal(this.id)
    });
});


/* Cette fonction va chercher via AJAX le contenu à afficher dans le modal
   Le contenu dépendra de l'action réalisé par l'utilisateur.
   Le controleur se charge de renvoyer le bon code.
*/
function charger_modal(nom_action) {
    alert(nom_action);

    $.ajax({
        url: "controller.php",
        method: "post",
        data: {action: nom_action}
    })
    .done(function(reponse) {
        var modal = $('#myModal');
        modal.find($('.modal-body')).html("<h1>" + reponse + "</h1>");


        $('#myModal').modal();
        $('.modal-backdrop').appendTo('#ecran');
        $('body').removeClass();
    });

    // Affichage du modal dans le div "ecran"
    //
    // http://stackoverflow.com/a/28386761
    //

}
