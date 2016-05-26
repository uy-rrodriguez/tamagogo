<?php
    include_once("bs/util.class.php");

    $assignes = array();
    if (isset($_SESSION["mascotte"]->decorations))
        $assignes = $_SESSION["mascotte"]->decorations;

    $inventaire = array();
    if (isset($_SESSION["inventaire_environn"]))
        $inventaire = $_SESSION["inventaire_environn"];
?>


<script>
    activer_drag(".modal-liste-double .modal-item",  // Elements a deplacer
                 ".modal-liste-double");             // Conteneur
    activer_drop("#liste-tama", ajouter_decoration);
    activer_drop("#liste-inventaire", supprimer_decoration);

    $(function() {
        /* Quand on clique sur un item d'une liste, on affiche un petit popup avec plus d'info. */
        activer_items_draggables_selectables(".modal-liste-double .modal-item", "details-");
    });
</script>


<div class="modal-liste modal-liste-double">

    <div id="liste-tama" class="gauche droppable">
<?php
        foreach ($assignes as $e) {
?>
            <a class="modal-item" id="<?php echo $e->id; ?>" style="background-color: <?php echo Util::randColor(); ?>;">
                <img src="<?php echo $e->img; ?>"></img>
            </a>
            <div class="item-details" id="details-<?php echo $e->id; ?>">
                <span class="item-nom"><?php echo $e->nom; ?></span>
                <ul>
<?php
                    foreach ($e->effets as $ef) {
                        $_SESSION["effet"] = $ef;
                        include("view/template/effet.php");
                    }
?>
                </ul>
            </div>
<?php
        }
?>
    </div>


    <div id="liste-inventaire" class="droite droppable">
<?php
        foreach ($inventaire as $e) {
?>
            <a class="modal-item" id="<?php echo $e->id; ?>" style="background-color: <?php echo Util::randColor(); ?>;">
                <img src="<?php echo $e->img; ?>"></img>
            </a>
            <div class="item-details" id="details-<?php echo $e->id; ?>">
                <span class="item-nom"><?php echo $e->nom; ?></span>
                <ul>
<?php
                    foreach ($e->effets as $ef) {
                        $_SESSION["effet"] = $ef;
                        include("view/template/effet.php");
                    }
?>
                </ul>
            </div>
<?php
        }
?>
    </div>

</div>

<div class="modal-boutons">
    <div class="gauche">
        <button type="button" class="btn btn-secondary" onclick="charger_modal('marche');">March&eacute;</button>
    </div>
    <div class="droite">
        <!--<button type="button" class="btn btn-primary">Sauvegarder</button>-->
    </div>
</div>
