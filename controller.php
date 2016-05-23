<?php
    //require_once("bs/dbconnection.class.php");
    require_once("model/animal.class.php");
    require_once("model/humanoide.class.php");
    require_once("model/monstre.class.php");
    require_once("model/utilisateur.class.php");


    session_start();


    $action = $_REQUEST["action"];

    switch ($action) {
        case "login":
            login();
            break;

        case "get_mascotte":
            get_mascotte();
            break;

        case "actualiser_etat":
            actualiser_etat();
            break;

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

    function retourner_erreur($msg) {
        echo json_encode(array("resultat" => "erreur",
                               "error" => $msg));
        exit();
    }

    function retourner_succes($attribs) {
        $reponse = array("resultat" => "OK");
        foreach($attribs as $cle => $valeur) {
            $reponse[$cle] = $valeur;
        }
        echo json_encode($reponse);
        exit();
    }

    function login() {
        try {
            $res = Utilisateur::controllerLogin($_REQUEST["nom"], $_REQUEST["mdp"]);
            if ($res == null)
                retourner_erreur("Nom ou mot de passe incorrect");
            else {
                $classe = Mascotte::getClasseByUtilisateur($res->id);
                $_SESSION["mascotte"] = (new $classe())->getByUtilisateur($res->id);
                $_SESSION["utilisateur"] = $res;
                retourner_succes(array("utilisateur" => $res,
                                       "mascotte" => $_SESSION["mascotte"]));
            }
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function test_stat(&$var) {
        $var = ($var + 1) % 100;
    }

    function get_mascotte() {
        try {
            retourner_succes(array("mascotte" => $_SESSION["mascotte"]));
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function actualiser_etat() {
        try {
            $m = $_SESSION["mascotte"];
            test_stat($m->sante);
            test_stat($m->bonheur);
            test_stat($m->faim);
            test_stat($m->pourcMaladie);
            retourner_succes(array("sante" => $m->sante,
                                   "bonheur" => $m->bonheur,
                                   "faim" => $m->faim,
                                   "maladie" => $m->pourcMaladie));
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }
?>
