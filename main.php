<?php
    include_once("view/template/head.php");

    if (!isset($_SESSION["utilisateur"]))
        exit();
?>
    <script>
        $(function() {
            //get_mascotte();
            actualiser_etat();
            cron_actualiser_etat(2000);
        });
    </script>

    <div id="ecran" class="main <?php echo 'environn-' . $_SESSION['mascotte']->id_env_actuel; ?>">

    <!-- ------------- IMAGE DU TAMA ACTUEL ----------------------------------------------------- -->

		<div id="tama" class="draggable <?php echo strtolower(get_class($_SESSION['mascotte'])); ?>">
		</div>


    <!-- ------------- BARRES AVEC LES ETATS ---------------------------------------------------- -->

		<div id="stats">
			<div id="stat-sante" class="stat normal draggable">
				<div class="barre">
					<span class="couleur" style="width: 1%;"></span>
					<span class="titre"></span>
				</div>
				<img src="img/sante.png">
			</div>
			<div id="stat-bonheur" class="stat normal draggable">
				<div class="barre">
					<span class="couleur" style="width: 1%;"></span>
					<span class="titre"></span>
				</div>
				<img src="img/bonheur.png">
			</div>
			<div id="stat-faim" class="stat inverse draggable">
				<div class="barre">
					<span class="couleur" style="width: 1%;"></span>
					<span class="titre"></span>
				</div>
				<img src="img/faim.png">
			</div>
			<div id="stat-maladie" class="stat inverse draggable">
				<div class="barre">
					<span class="couleur" style="width: 1%;"></span>
					<span class="titre"></span>
				</div>
				<img src="img/maladie.png">
			</div>
		</div>


    <!-- ------------- ACTIONS DISPONIBLES ------------------------------------------------------ -->

		<div id="actions">
			<div class="action draggable">
				<div id="liste_nourriture" class="bouton lancer-modal" data-title="Nourrir">
					<img src="img/nourrir.png">
				</div>
			</div>
			<div class="action draggable">
				<div id="liste_medicaments" class="bouton lancer-modal" data-title="Soigner">
					<img src="img/soigner.png">
				</div>
			</div>
			<div class="action draggable">
				<div id="liste_jeux" class="bouton lancer-modal" data-title="Jouer">
					<img src="img/jouer.png">
				</div>
			</div>
			<div class="action draggable">
				<div id="liste_vetements" class="bouton lancer-modal" data-title="Habiller">
					<img src="img/habiller.png">
				</div>
			</div>
			<div class="action draggable">
				<div id="liste_decorations" class="bouton lancer-modal" data-title="Environn.">
					<img src="img/environnement.png">
				</div>
			</div>
		</div>


    <!-- ------------- BOUTONS BAS GAUCHE ------------------------------------------------------- -->

        <div id="tuer" class="action action-speciale draggable">
			<div class="bouton" data-title="Tuer">
                <img src="img/tuer.png">
            </div>
		</div>
		<div id="sortir" class="action action-speciale draggable">
			<div class="bouton" data-title="Sortir">x</div>
		</div>


    <!-- ------------- NOM MASCOTTE, BAS CENTRE ------------------------------------------------- -->

        <div id="nom-mascotte" class="draggable">
			<?php echo $_SESSION["mascotte"]->nom; ?>
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
