<?php
    include_once("bs/util.class.php");

    $elements = array();
    for ($i = 0; $i < 5 ; $i++) {
        $color = Util::randColor();
        $elements[] = array("color"   => $color,
                            "nom"     => "Jeu",
                            "img"     => "img/jeu.png",
                            "cout"    => 15,
                            "gain"    => 300,
                            "id"      => 1);
    }
?>


<script>
    $(function() {
        /* Quand on clique sur un item d'une liste, on affiche un petit popup avec plus d'info. */
        activer_items_selectables(".modal-liste-jeux .modal-item", "details-");
    });
</script>


<div class="modal-liste modal-liste-jeux">
    <div class="container">

<?php
        foreach ($elements as $e) {
?>
            <a href='#' class='modal-item' id="<?php echo $e['id']; ?>" style='background-color: <?php echo $e["color"]; ?>;'>
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
        <span id="argent">
            <img src="img/argent.png" />
            <span id="total-argent"><?php echo $_SESSION["utilisateur"]->argent; ?></span>
        </span>
    </div>
    <div class="droite">
        <button type="button" class="btn btn-primary" onclick="jouer();">Jouer</button>
    </div>
</div>
