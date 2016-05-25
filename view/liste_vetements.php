<?php
    include_once("bs/util.class.php");

    $assignes = array();
    for ($i = 0; $i < 9 ; $i++) {
        $color = Util::randColor();
        $assignes[] = "<div class='modal-item' style='background-color: $color;'></div>";
    }

    $marche = array();
    if (isset($_SESSION["inventaire_habiller"]))
        $marche = $_SESSION["inventaire_habiller"];
?>


<script>
    activer_drag_drop(".modal-liste-double .modal-item",
                      ".modal-liste-double",
                      ".modal-liste-double > .droppable");
</script>


<div class="modal-liste modal-liste-double">
    <div id="liste-tama" class="gauche droppable">

<?php
        foreach ($assignes as $e) {
            echo $e;
        }
?>
    </div>


    <div id="liste-marche" class="droite droppable">

<?php
        foreach ($marche as $e) {
?>
            <div class="modal-item" id="<?php echo $e->id; ?>" style="background-color: <?php echo Util::randColor(); ?>;">
                <img src="<?php echo $e->img; ?>"></img>
            </div>
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
        <button type="button" class="btn btn-primary">Sauvegarder</button>
    </div>
</div>
