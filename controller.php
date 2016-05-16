<?php

    $action = $_REQUEST["action"];

    switch ($action) {
        case "nourrir":
            echo get_contenu_modal("view/nourrir.php", "Nourrir");
            break;

        case "soigner":
            echo get_contenu_modal("view/soigner.php", "Soigner");
            break;

        case "habiller":
            echo get_contenu_modal("view/habiller.php", "Habiller");
            break;

        case "environnement":
            echo get_contenu_modal("view/environnement.php", "Modifier environnement");
            break;

        case "jouer":
            echo get_contenu_modal("view/liste_jeux.php", "S&eacute;lectionner un jeu");
            break;

        case "marche":
            echo get_contenu_modal("view/marche.php", "Bienvenu au march&eacute;");
            break;
    }


    function get_contenu_modal($vue, $titre) {
        ob_start();
        include($vue);
        $contenu = ob_get_contents();
        ob_end_clean();
        return json_encode(array("contenu" => $contenu,
                                 "titre" => $titre));
    }
?>
