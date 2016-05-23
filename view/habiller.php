<?php
    include_once("bs/util.class.php");

    $assignes = array();
    for ($i = 0; $i < 9 ; $i++) {
        $color = Util::randColor();
        $assignes[] = "<div class='modal-item' style='background-color: $color;'></div>";
    }

    $marche = array();
    for ($i = 0; $i < 9 ; $i++) {
        $color = Util::randColor();
        $marche[] = "<div class='modal-item' style='background-color: $color;'></div>";
    }
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
            echo $e;
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
