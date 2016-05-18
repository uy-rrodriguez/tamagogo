<?php
    include_once("bs/util.class.php");
    include_once("model/nourriture.class.php");

    $elements = array();
    for ($i = 0; $i < 40 ; $i++) {
        $e = new Nourriture();
//         $e->color = $color;
//         $e->id;
//         $e->nom;
//         $e->prix;
//         $e->effets;
        $e->img = "img/nourrir.png";
        $elements[] = $e;
    }
?>

<div class="modal-liste-simple">

<?php
    foreach ($elements as $e) {
?>
        <a href="#" class="modal-item" style="background-color: <?php echo Util::randColor(); ?>;">
            <img src="<?php echo $e->img; ?>"></img>
        </a>
<?php
    }
?>

</div>

<div class="modal-boutons">
    <div class="gauche">
        <button type="button" class="btn btn-secondary" onclick="charger_modal('marche');">March&eacute;</button>
    </div>
    <div class="droite">
        <button type="button" class="btn btn-primary">Nourrir</button>
    </div>
</div>
