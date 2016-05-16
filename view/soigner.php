<?php
    include_once("bs/util.class.php");

    $elements = array();
    for ($i = 0; $i < 40 ; $i++) {
        $color = Util::randColor();
        $elements[] = "<div class='modal-item' style='background-color: $color;'></div>";
    }
?>

<div class="modal-liste-simple">

<?php
    foreach ($elements as $e) {
        echo $e;
    }
?>

</div>

<div class="modal-boutons">
    <div class="gauche">
        <button type="button" class="btn btn-secondary">March&eacute;</button>
    </div>
    <div class="droite">
        <button type="button" class="btn btn-primary">Nourrir</button>
    </div>
</div>
