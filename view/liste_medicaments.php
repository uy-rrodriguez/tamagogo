<?php
    include_once("bs/util.class.php");
    include_once("model/medicament.class.php");

    $elements = array();
    if (isset($_SESSION["inventaire_soigner"]))
        $elements = $_SESSION["inventaire_soigner"];
?>

<div class="modal-liste modal-liste-simple">

<?php
    foreach ($elements as $e) {
?>
        <a href="#" class="modal-item" id="<?php echo $e->id; ?>" style="background-color: <?php echo Util::randColor(); ?>;">
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

<div class="modal-boutons">
    <div class="gauche">
        <button type="button" class="btn btn-secondary" onclick="charger_modal('marche');">March&eacute;</button>
    </div>
    <div class="droite">
        <button type="button" class="btn btn-primary" onclick="soigner();">Soigner</button>
    </div>
</div>

<script>
    /* Quand on clique sur un item d'une liste, on affiche un petit popup avec plus d'info. */
    activer_items_selectables(".modal-liste-simple .modal-item", "details-");
</script>
