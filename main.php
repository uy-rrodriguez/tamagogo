<?php
    include_once("view/template/head.php");
?>
    <script>
        $(function() {
            get_mascotte();
            cron_actualiser_etat(1000);
        });
    </script>

    <div id="ecran" class="main">

    <!-- ------------- IMAGE DU TAMA ACTUEL ----------------------------------------------------- -->

		<div id="tama" class="draggable">
			<!--<img src="img/tamas/nicolas.png">-->
		</div>


    <!-- ------------- BARRES AVEC LES ETATS ---------------------------------------------------- -->

		<div id="stats">
			<div id="stat-sante" class="stat haut draggable">
				<div class="barre">
					<span class="couleur" style="width: 85%;"></span>
					<span class="titre"></span>
				</div>
				<img src="img/sante.png">
			</div>
			<div id="stat-bonheur" class="stat haut draggable">
				<div class="barre">
					<span class="couleur" style="width: 70%;"></span>
					<span class="titre"></span>
				</div>
				<img src="img/bonheur.png">
			</div>
			<div id="stat-faim" class="stat moyen draggable">
				<div class="barre">
					<span class="couleur" style="width: 40%;"></span>
					<span class="titre"></span>
				</div>
				<img src="img/faim.png">
			</div>
			<div id="stat-maladie" class="stat bas draggable">
				<div class="barre">
					<span class="couleur" style="width: 10%;"></span>
					<span class="titre"></span>
				</div>
				<img src="img/maladie.png">
			</div>
		</div>


    <!-- ------------- ACTIONS DISPONIBLES ------------------------------------------------------ -->

		<div id="actions">
			<div class="action draggable">
				<div id="nourrir" class="bouton" data-title="Nourrir">
					<img src="img/nourrir.png">
				</div>
<!-- 				<span class="titre">Nourrir</span> -->
			</div>
			<div class="action draggable">
				<div id="jouer" class="bouton" data-title="Jouer">
					<img src="img/jouer.png">
				</div>
<!-- 				<span class="titre">Jouer</span> -->
			</div>
			<div class="action draggable">
				<div id="soigner" class="bouton" data-title="Soigner">
					<img src="img/soigner.png">
				</div>
<!-- 				<span class="titre">Soigner</span> -->
			</div>
			<div class="action draggable">
				<div id="habiller" class="bouton" data-title="Habiller">
					<img src="img/habiller.png">
				</div>
<!-- 				<span class="titre">Habiller</span> -->
			</div>
			<div class="action draggable">
				<div id="environnement" class="bouton" data-title="Environn.">
					<img src="img/environnement.png">
				</div>
<!-- 				<span class="titre">Environnement</span> -->
			</div>
		</div>


    <!-- ------------- MODAL QUI DEPEND DES ACTIONS EXECUTEES ----------------------------------- -->

        <div id="modal-action" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <!-- Ici ira le contenu du modal -->
                    </div>
                    <!--
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    </div>
                    -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div><!-- /.ecran .main-->

<?php
    include_once("view/template/foot.php");
?>
