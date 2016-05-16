<?php
    include_once("bs/util.class.php");

    $elements = array();
    for ($i = 0; $i < 100 ; $i++) {
        $color = Util::randColor();
        $elements[] = array("color"   => $color,
                            "nom"     => $color,
                            "img"     => "img/nourrir.png",
                            "prix"    => 300);
    }
?>

<div class="modal-liste-marche">

<?php
        foreach ($elements as $e) {
?>
            <a href='#' class='modal-item' style='background-color: <?php echo $e["color"]; ?>;'>
                <div class="marche-entete">
                    <span class="marche-nom"><?php echo $e["nom"]; ?></span>
                </div>

                <div class="marche-contenu">
                    <img class="marche-img" src="<?php echo $e["img"]; ?>"></img>
                </div>

                <div class="marche-pied">
                    <span class="marche-prix"><?php echo $e["prix"]; ?></span>
                </div>
            </a>
<?php
        }
?>

</div>

<div class="modal-boutons">
    <div class="gauche">
        <span class="total-argent">Vous avez 15 tama$</span>
    </div>
    <div class="droite">
        <button type="button" class="btn btn-primary">Acheter</button>
    </div>
</div>
