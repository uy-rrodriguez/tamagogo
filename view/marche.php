<?php
    include_once("bs/util.class.php");

    $elements = array();
    if (isset($_SESSION["objets_marche"]))
        $elements = $_SESSION["objets_marche"];
?>


<script>
    $(function() {
        /* Quand on clique sur un item d'une liste, on affiche un petit popup avec plus d'info. */
        activer_items_selectables(".modal-liste-marche .modal-item", "details-");
    });
</script>


<div class="modal-liste modal-liste-marche">

<?php
        foreach ($elements as $e) {
?>
            <a href='#' class='modal-item' id="<?php echo $e->id; ?>" style="background-color: <?php Util::randColor(); ?>;">
                <div class="marche-entete">
                    <span class="marche-nom"><?php echo $e->nom; ?></span>
                </div>

                <div class="marche-contenu">
                    <img class="marche-img" src="<?php echo $e->img; ?>"></img>
                </div>

                <div class="marche-pied">
                    <span class="marche-prix"><?php echo $e->prix; ?></span>
                </div>
            </a>
            <div class="item-details" id="details-<?php echo $e->id; ?>">
                <span class="item-nom">Effets</span>
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
        <span id="argent">
            <img src="img/argent.png" />
            <span id="total-argent"><?php echo $_SESSION["utilisateur"]->argent; ?></span>
        </span>
    </div>
    <div class="droite">
        <button type="button" class="btn btn-primary" onclick="acheter();">Acheter</button>
    </div>
</div>
