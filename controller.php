<?php
    //require_once("bs/dbconnection.class.php");
    require_once("model/animal.class.php");
    require_once("model/humanoide.class.php");
    require_once("model/monstre.class.php");
    require_once("model/utilisateur.class.php");
    require_once("model/objetfactory.class.php");


    session_start();


    /* *************************************************************************************************** */
    /*                  DÉCISION DE L'OPÉRATION À EXÉCUTER                                                 */
    /* *************************************************************************************************** */

    $action = $_REQUEST["action"];

    switch ($action) {
        case "login":
            login();
            break;

        case "logout":
            logout();
            break;

        case "get_mascotte":
            get_mascotte();
            break;

        case "actualiser_etat":
            actualiser_etat();
            break;

        case "marche":
            marche();
            break;

        case "acheter":
            acheter();
            break;

        case "liste_nourriture":
            liste_nourriture();
            break;

        case "nourrir":
            nourrir();
            break;

        case "liste_medicaments":
            liste_medicaments();
            break;

        case "soigner":
            soigner();
            break;

        case "habiller":
            habiller();
            break;

        case "environnement":
            environnement();
            break;

        case "jouer":
            echo get_contenu_modal("view/liste_jeux.php", "S&eacute;lectionner un jeu");
            break;
    }



    /* *************************************************************************************************** */
    /*                  FONCTIONS UTILES                                                                   */
    /* *************************************************************************************************** */

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

    function retourner_succes($attribs = array()) {
        $reponse = array("resultat" => "OK");
        foreach($attribs as $cle => $valeur) {
            $reponse[$cle] = $valeur;
        }
        echo json_encode($reponse);
        exit();
    }

    function set_inventaire() {
        try {
            if (! isset($_SESSION["inventaire"])) {
                $_SESSION["inventaire"] = array();
            }
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    // Actualise un etat a partir d'une valeur et realise les controles necessaires
    function changer_etat(&$var_etat, $coef) {
        $var_etat += $coef;
        if ($var_etat > 100)
            $var_etat = 100;
        else if ($var_etat < 0)
            $var_etat = 0;
        else
            $var_etat = intval($var_etat);

    }

    // Actualise l'etat a partir des effets d'un objet
    function actualiser_etat_objet($objet) {
        try {
            $m = $_SESSION["mascotte"];
            foreach ($objet->effets as $e) {
                switch($e->attribut) {
                    case "sante":     changer_etat($m->sante, $e->coef); break;
                    case "bonheur":   changer_etat($m->bonheur, $e->coef); break;
                    case "faim":      changer_etat($m->faim, $e->coef); break;
                    case "maladie":   changer_etat($m->pourc_maladie, $e->coef); break;
                }
            }
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }



    /* *************************************************************************************************** */
    /*                  FONCTIONNALITÉS PROPOSÉES PAR LE SYSTÈME                                           */
    /* *************************************************************************************************** */

    function login() {
        //sleep(1);
        try {
            $res = Utilisateur::controllerLogin($_REQUEST["nom"], $_REQUEST["mdp"]);
            if ($res == null)
                retourner_erreur("Nom ou mot de passe incorrect");
            else {
                $classe = Mascotte::getClasseByUtilisateur($res->id);

                // Inicialisation de la session
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

    function logout() {
        try {
            session_destroy();
            retourner_succes();
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function get_mascotte() {
        try {
            retourner_succes(array("mascotte" => $_SESSION["mascotte"]));
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }


    // Cette fonction actualise l'etat en fonction des objets lies a la mascotte (environnement, vetements)
    // et par rapport a l'heure de derniere connexion
    function actualiser_etat() {
        try {
            $m = $_SESSION["mascotte"];

            // Actualisation de base
            changer_etat($m->sante, -1);
            changer_etat($m->bonheur, -2);
            changer_etat($m->faim, 2);
            changer_etat($m->pourc_maladie, 1);

            // Actualisation selon l'environnement

            // Actualisation selon les vetements


            retourner_succes(array("sante" => $m->sante,
                                   "bonheur" => $m->bonheur,
                                   "faim" => $m->faim,
                                   "maladie" => $m->pourc_maladie));
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function marche() {
        try {
            $_SESSION["objets_marche"] = ObjetFactory::genererObjetsDuMarche();
            echo get_contenu_modal("view/marche.php", "Bienvenu au march&eacute;");
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function acheter() {
        try {
            // On cherche l'objet dans le marche
            if (! isset($_SESSION["objets_marche"]))
                throw new Exception("Le marché n'a pas été chargé");

            $key_achete = null;
            $achete = null;
            foreach ($_SESSION["objets_marche"] as $key => $o) {
                if ($o->id == $_REQUEST["id_objet"]) {
                    $achete = $o;
                    $key_achete = $key;
                    break;
                }
            }
            if ($achete == null)
                throw new Exception("L'objet " . $_REQUEST["id_objet"] . " n'a pas été trouvé dans la session");

            // On l'ajoute dans l'inventaire et on le stocke dans la BD
            // Avant de faire ca, on supprime l'id genere par le ObjectFactory
            unset($achete->id);
            $achete->utilisateur = $_SESSION["utilisateur"];
            $achete->save();

            // On le supprime du marche
            unset($_SESSION["objets_marche"][$key_achete]);

            retourner_succes();
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function liste_nourriture() {
        try {
            $_SESSION["inventaire_nourrir"] = (new Nourriture())->getByUtilisateur($_SESSION["utilisateur"]->id);
            echo get_contenu_modal("view/liste_nourriture.php", "Nourrir");
        }
        catch(Exception $ex) {
            echo $ex->getMessage();
        }
    }

    function nourrir() {
        try {
            // On cherche l'objet dans la liste
            if (! isset($_SESSION["inventaire_nourrir"]))
                throw new Exception("La liste de nourritures n'a pas été chargée");

            $key_objet = null;
            $objet = null;
            foreach ($_SESSION["inventaire_nourrir"] as $key => $o) {
                if ($o->id == $_REQUEST["id_objet"]) {
                    $objet = $o;
                    $key_objet = $key;
                    break;
                }
            }
            if ($objet == null)
                throw new Exception("La nourriture " . $_REQUEST["id_objet"] . " n'a pas été trouvé dans la session");

            // On change l'etat a partir des effets
            actualiser_etat_objet($objet);

            // On supprime l'objet de la BD
            $objet->del_complex();

            // On le supprime de la liste
            unset($_SESSION["inventaire_nourrir"][$key_objet]);

            retourner_succes();
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function liste_medicaments() {
        try {
            $_SESSION["inventaire_soigner"] = (new Medicament())->getByUtilisateur($_SESSION["utilisateur"]->id);
            echo get_contenu_modal("view/liste_medicaments.php", "Soigner");
        }
        catch(Exception $ex) {
            echo $ex->getMessage();
        }
    }

    function soigner() {
        try {
            // On cherche l'objet dans la liste
            if (! isset($_SESSION["inventaire_soigner"]))
                throw new Exception("La liste de médicaments n'a pas été chargée");

            $key_objet = null;
            $objet = null;
            foreach ($_SESSION["inventaire_soigner"] as $key => $o) {
                if ($o->id == $_REQUEST["id_objet"]) {
                    $objet = $o;
                    $key_objet = $key;
                    break;
                }
            }
            if ($objet == null)
                throw new Exception("Le médicament " . $_REQUEST["id_objet"] . " n'a pas été trouvé dans la session");

            // On change l'etat a partir des effets
            actualiser_etat_objet($objet);

            // On supprime l'objet de la BD
            $objet->del_complex();

            // On le supprime de la liste
            unset($_SESSION["inventaire_soigner"][$key_objet]);

            retourner_succes();
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function habiller() {
        try {
            set_inventaire();
            echo get_contenu_modal("view/habiller.php", "Habiller");
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function environnement() {
        try {
            set_inventaire();
            echo get_contenu_modal("view/environnement.php", "Modifier environnement");
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }
?>
