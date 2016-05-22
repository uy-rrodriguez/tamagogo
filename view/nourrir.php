<?php
    include_once("bs/util.class.php");
    include_once("model/nourriture.class.php");

    $elements = array();
    for ($i = 0; $i < 40 ; $i++) {
        $e = new Nourriture();
//         $e->color = $color;
//         $e->nom;
//         $e->prix;
//         $e->effets;
        $e->id = $i;
        $e->img = "img/nourrir.png";
        $elements[] = $e;
    }

    $n = new Nourriture();
    $ns = $n->getAll();
    var_dump($ns);
?>

<div class="modal-liste-simple">

<?php
    foreach ($elements as $e) {
?>
        <a href="#" class="modal-item" id="<?php echo $e->id; ?>" style="background-color: <?php echo Util::randColor(); ?>;">
            <img src="<?php echo $e->img; ?>"></img>
        </a>
        <div class="item-details" id="details-<?php echo $e->id; ?>">
            <span class="item-nom"><?php echo $e->id; ?></span>
            <ul>
                <li>Santé +1</li>
                <li>Bonheur +15</li>
                <li>Faim -10</li>
                <li>Maladie +1</li>
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
        <button type="button" class="btn btn-primary" onclick="nourrir();">Nourrir</button>
    </div>
</div>

<script>
    /* Quand on clique sur un item d'une liste, on affiche un petit popup avec plus d'info. */
    activer_items_selectables(".modal-liste-simple .modal-item", "details-");
</script>
