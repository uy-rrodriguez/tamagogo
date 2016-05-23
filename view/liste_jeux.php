<?php
    include_once("bs/util.class.php");

    $elements = array();
    for ($i = 0; $i < 5 ; $i++) {
        $color = Util::randColor();
        $elements[] = array("color"   => $color,
                            "nom"     => $color,
                            "img"     => "img/nourrir.png",
                            "cout"    => 15,
                            "gain"    => 300);
    }
?>

<div class="modal-liste modal-liste-jeux">
    <div class="container">

<?php
        foreach ($elements as $e) {
?>
            <a href='#' class='modal-item' style='background-color: <?php echo $e["color"]; ?>;'>
                <div class="jeux-entete">
                    <span class="jeux-nom"><?php echo $e["nom"]; ?></span>
                    <span class="jeux-cout"><?php echo $e["cout"]; ?></span>
                </div>

                <div class="jeux-contenu">
                    <img class="jeux-img" src="<?php echo $e["img"]; ?>"></img>
                </div>

                <div class="jeux-pied">
                    <span class="jeux-gain"><?php echo $e["gain"]; ?></span>
                </div>
            </a>
<?php
        }
?>

    </div>
</div>

<div class="modal-boutons">
    <div class="gauche">
        <span class="total-argent">Vous avez 15 tama$</span>
    </div>
    <div class="droite">
        <button type="button" class="btn btn-primary">Jouer</button>
    </div>
</div>
