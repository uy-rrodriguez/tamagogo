<?php
    include_once("view/template/head.php");
?>

    <div id="ecran" class="index">

        <!--<div id="index-accue2il" class="modal fade" role="dialog">-->
        <div id="index-accue2il" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">

                        <form id="login">
                            <div id="titre">
                                <span id="titre-tama">tama</span>
                                <span id="titre-gogo">GOGO</span>
                            </div>
                            <input type="text" name="nom" placeholder="Nom" />
                            <input type="password" name="mdp" placeholder="Mot de passe" />

                            <!--
                            <input type="button" id="btn-login" class="bouton" value="Login" />
                            <input type="button" id="btn-inscription" class="bouton" value="Inscription" />
                            -->

                            <a class="bouton" id="btn-login" onclick="login();"><div>Login</div></a>
                            <a class="bouton" id="btn-inscription"><div>Inscription</div></a>
                        <form>

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div><!-- /.ecran .main-->


    <script>
        afficher_modal("#index-accueil", true);

    </script>

<?php
    include_once("view/template/foot.php");
?>
