<?php
    include_once("view/template/head.php");
?>

    <script>
        $(function() {
            afficher_modal("#creation-mascotte", true);

            $("input").keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode == 13)
                    return false;
            });
        });
    </script>

    <div id="ecran" class="creation-mascotte">

        <div id="creation-mascotte" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">

                        <form id="form-creation-mascotte">
                            <div id="titre">
                                <span id="titre-tama">Création tama</span>
                                <span id="titre-gogo">GOGO</span>
                            </div>

                            <input type="text" name="nom" placeholder="Nom" />
                            <select name="sexe" placeholder="Sexe">
                                <option value="femelle">Fille</option>
                                <option value="male">Gar&ccedil;on</option>
                            </select>

                            <div id="options-mascotte">
                                <a href="#" id="humanoide" class="bouton" onclick="creer_mascotte('Humanoide');"></a>
                                <a href="#" id="animal" class="bouton" onclick="creer_mascotte('Animal');"></a>
                                <a href="#" id="monstre" class="bouton" onclick="creer_mascotte('Monstre');"></a>
                            </div>
                        </form>

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div><!-- /.ecran .main-->

<?php
    include_once("view/template/foot.php");
?>
