<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>tamaGOGO</title>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="bootstrap-3.3.6/js/bootstrap.min.js"></script>
	<script src="js/functions.js"></script>

	<link href='https://fonts.googleapis.com/css?family=Oxygen:400,700' rel='stylesheet' type='text/css'>
    <link href='bootstrap-3.3.6/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
    <link href='css/style.css' rel='stylesheet' type='text/css'>
</head>
<body>

	<div id="ecran">

    <!-- ------------- IMAGE DU TAMA ACTUEL ----------------------------------------------------- -->

		<div id="tama" class="draggable">
			<img src="img/tamas/nicolas.png">
		</div>


    <!-- ------------- BARRES AVEC LES ETATS ---------------------------------------------------- -->

		<div id="stats">
			<div class="stat haut draggable">
				<div class="barre">
					<span class="couleur" style="width: 85%;"></span>
					<span class="titre">Santé 85%</span>
				</div>
				<img src="img/sante.png">
			</div>
			<div class="stat haut draggable">
				<div class="barre">
					<span class="couleur" style="width: 70%;"></span>
					<span class="titre">Bonheur 70%</span>
				</div>
				<img src="img/bonheur.png">
			</div>
			<div class="stat moyen draggable">
				<div class="barre">
					<span class="couleur" style="width: 40%;"></span>
					<span class="titre">Faim 40%</span>
				</div>
				<img src="img/faim.png">
			</div>
			<div class="stat bas draggable">
				<div class="barre">
					<span class="couleur" style="width: 10%;"></span>
					<span class="titre">Maladie 10%</span>
				</div>
				<img src="img/maladie.png">
			</div>
		</div>


    <!-- ------------- ACTIONS DISPONIBLES ------------------------------------------------------ -->

		<div id="actions">
			<div class="action draggable">
				<div id="nourrir" class="bouton">
					<img src="img/nourrir.png">
				</div>
				<span class="titre">Nourrir</span>
			</div>
			<div class="action draggable">
				<div id="jouer" class="bouton">
					<img src="img/jouer.png">
				</div>
				<span class="titre">Jouer</span>
			</div>
			<div class="action draggable">
				<div id="soigner" class="bouton">
					<img src="img/soigner.png">
				</div>
				<span class="titre">Soigner</span>
			</div>
			<div class="action draggable">
				<div id="habiller" class="bouton">
					<img src="img/habiller.png">
				</div>
				<span class="titre">Habiller</span>
			</div>
			<div class="action draggable">
				<div id="environnement" class="bouton">
					<img src="img/environnement.png">
				</div>
				<span class="titre">Environnement</span>
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
	</div>

</body>
</html>
