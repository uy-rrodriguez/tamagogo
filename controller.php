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

        case "liste_vetements":
            liste_vetements();
            break;

        case "habiller":
            habiller();
            break;

        case "deshabiller":
            deshabiller();
            break;

        case "liste_decorations":
            liste_decorations();
            break;

        case "ajouter_decoration":
            ajouter_decoration();
            break;

        case "supprimer_decoration":
            supprimer_decoration();
            break;

        case "liste_jeux":
            echo get_contenu_modal("view/liste_jeux.php", "S&eacute;lectionner un jeu");
            break;

        case "jouer":
            jouer();
            break;

        case "creer_mascotte":
            creer_mascotte();
            break;

        case "tuer":
            tuer();
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

    function retourner_redirect($page) {
        echo json_encode(array("resultat" => "redirect",
                               "page" => $page));
        exit();
    }


    // Charge la mascotte de la base de donnes a partir de l'utilisateur connecte
    function charger_mascotte() {
        // Recherche de la mascotte
        $classe = Mascotte::getClasseByUtilisateur($_SESSION["utilisateur"]->id);

        if (is_null($classe))
            return false;

        else {
            $m = (new $classe())->getByUtilisateur($_SESSION["utilisateur"]->id);
            $m->vetements = (new Vetement())->getByMascotte($m->id);
            $m->decorations = (new Decoration())->getByMascotte($m->id);
            $_SESSION["mascotte"] = $m;
            return true;
        }
    }


    // Actualise un etat a partir d'une valeur et realise les controles necessaires
    function changer_etat(&$var_etat, $coef) {
        $var_etat += ($coef / 10);
        if ($var_etat > 100)
            $var_etat = 100;
        else if ($var_etat < 0)
            $var_etat = 0;
        /*
        else
            $var_etat = intval($var_etat);
        */

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

    // Fonction auxiliare pour supporter le drag and drop entre l'inventaire et la mascotte
    function drag_drop($id_objet, &$liste_drag, &$liste_drop, $vers_mascotte) {
        try {
            // On cherche l'objet dans la liste de départ
            $key_objet = null;
            $objet = null;
            foreach ($liste_drag as $key => $o) {
                if ($o->id == $id_objet) {
                    $objet = $o;
                    $key_objet = $key;
                    break;
                }
            }
            if ($objet == null)
                throw new Exception("L'objet " . $id_objet . " n'a pas été trouvé dans la session");

            // Les objets vont de la mascotte à l'inventaire ou viceversa.
            // Le paramètre $vers_mascotte permet de déterminer comment affecter la base de données.
            if ($vers_mascotte) {
                unset($objet->utilisateur);
                $objet->id_utilisateur = null;
                $objet->mascotte = $_SESSION["mascotte"];
                $objet->id_mascotte = $objet->mascotte->id;
            }
            else {
                unset($objet->mascotte);
                $objet->id_mascotte = null;
                $objet->utilisateur = $_SESSION["utilisateur"];
                $objet->id_utilisateur = $objet->utilisateur->id;
            }

            // Modification dans la base de données
            $objet->update();

            // On le déplace de liste
            $liste_drop[] = $objet;
            unset($liste_drag[$key_objet]);
            $liste_drag = array_values($liste_drag);
        }
        catch(Exception $ex) {
            throw new Exception("Erreur de drag&drop. " . $ex->getMessage());
        }
    }



    /* *************************************************************************************************** */
    /*                  FONCTIONNALITÉS PROPOSÉES PAR LE SYSTÈME                                           */
    /* *************************************************************************************************** */

    function login() {
        try {
            $res = Utilisateur::controllerLogin($_REQUEST["nom"], $_REQUEST["mdp"]);
            if ($res == null)
                retourner_erreur("Nom ou mot de passe incorrect");
            else {
                // Inicialisation de la session
                $_SESSION["utilisateur"] = $res;

                // On charge les donnes de la mascotte
                $existe = charger_mascotte();

                // S'il n'y a pas de mascotte, on va a la page de creation
                if (! $existe) {
                    retourner_redirect("creation.php");
                }
                else {
                    // Pour chaque heure qui s'est passe depuis la derniere connexion, on calcule l'etat
                    $now = time();
                    $diff = $now - $_SESSION["utilisateur"]->derniere_connexion;
                    $heures = $diff / 60 / 60; // heures = secondes / 60 / 60
                    for ($heures; $heures > 0; $heures--)
                        actualiser_etat();

                    retourner_succes(array("utilisateur" => $res,
                                           "mascotte" => $_SESSION["mascotte"]));
                }
            }
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function logout() {
        try {
            // Stockage de l'utilisateur
            $_SESSION["utilisateur"]->derniere_connexion = time();
            $_SESSION["utilisateur"]->save();

            // Stockage de la mascotte
            $_SESSION["mascotte"]->update();

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
    function actualiser_etat() {
        try {
            $m = $_SESSION["mascotte"];

            // Actualisation de base
            changer_etat($m->sante, -20);
            changer_etat($m->bonheur, -20);
            changer_etat($m->faim, 10);
            changer_etat($m->pourc_maladie, 10);

            // Actualisation selon l'environnement
            $decos = array();
            if (isset($_SESSION["mascotte"]->decorations))
                $decos = $_SESSION["mascotte"]->decorations;
            foreach ($decos as $d) {
                actualiser_etat_objet($d);
            }

            // Actualisation selon les vetements
            $vets = array();
            if (isset($_SESSION["mascotte"]->vetements))
                $vets = $_SESSION["mascotte"]->vetements;
            foreach ($vets as $v) {
                actualiser_etat_objet($v);
            }

            $m->sante = intval($m->sante);
            $m->bonheur = intval($m->bonheur);
            $m->faim = intval($m->faim);
            $m->pourc_maladie = intval($m->pourc_maladie);

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

            // Controle d'argent disponible
            if ($_SESSION["utilisateur"]->argent >= $achete->prix) {

                // On l'ajoute dans l'inventaire et on le stocke dans la BD
                // Avant de faire ca, on supprime l'id genere par le ObjectFactory
                unset($achete->id);
                $achete->save();

                // On le supprime du marche
                unset($_SESSION["objets_marche"][$key_achete]);

                // Reduction de l'argent
                $_SESSION["utilisateur"]->argent -= $achete->prix;

                retourner_succes(array("argent" => $_SESSION["utilisateur"]->argent));
            }
            else {
                retourner_erreur("Tu n'as pas suffisamment d'argent.");
            }
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

    function liste_vetements() {
        try {
            $liste = (new Vetement())->getByUtilisateur($_SESSION["utilisateur"]->id);
            /*
            // Un petit detail, il faut supprimer les objets associes a une mascotte
            for ($i = 0; $i < count($liste); $i++) {
                if ($liste[$i]->id_mascotte)
                    unset($liste[$i]);
            }
            */

            $_SESSION["inventaire_habiller"] = $liste;
            //$_SESSION["mascotte"]->vetements = (new Vetement())->getByMascotte($_SESSION["mascotte"]->id);
            echo get_contenu_modal("view/liste_vetements.php", "Habiller");
        }
        catch(Exception $ex) {
            echo $ex->getMessage();
        }
    }

    function habiller() {
        try {
            if (! isset($_SESSION["inventaire_habiller"]))
                throw new Exception("La liste de vêtements n'a pas été chargée dans la session");

            if (! isset($_SESSION["mascotte"]->vetements))
                $_SESSION["mascotte"]->vetements = array();

            drag_drop($_REQUEST["id_objet"], $_SESSION["inventaire_habiller"], $_SESSION["mascotte"]->vetements, true);

            retourner_succes();
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function deshabiller() {
        try {
            if (! isset($_SESSION["inventaire_habiller"]))
                $_SESSION["inventaire_habiller"] = array();

            drag_drop($_REQUEST["id_objet"], $_SESSION["mascotte"]->vetements, $_SESSION["inventaire_habiller"], false);

            retourner_succes();
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function liste_decorations() {
        try {
            $liste = (new Decoration())->getByUtilisateur($_SESSION["utilisateur"]->id);
            /*
            // Un petit detail, il faut supprimer les objets associes a une mascotte
            for ($i = 0; $i < count($liste); $i++) {
                if ($liste[$i]->id_mascotte)
                    unset($liste[$i]);
            }
            */

            $_SESSION["inventaire_environn"] = $liste;
            //$_SESSION["mascotte"]->decorations = (new Decoration())->getByMascotte($_SESSION["mascotte"]->id);
            echo get_contenu_modal("view/liste_decorations.php", "Modifier environnement");
        }
        catch(Exception $ex) {
            echo $ex->getMessage();
        }
    }

    function ajouter_decoration() {
        try {
            if (! isset($_SESSION["inventaire_environn"]))
                throw new Exception("La liste de décorations n'a pas été chargée dans la session");

            if (! isset($_SESSION["mascotte"]->decorations))
                $_SESSION["mascotte"]->decorations = array();

            drag_drop($_REQUEST["id_objet"], $_SESSION["inventaire_environn"], $_SESSION["mascotte"]->decorations, true);

            retourner_succes();
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function supprimer_decoration() {
        try {
            if (! isset($_SESSION["inventaire_environn"]))
                $_SESSION["inventaire_environn"] = array();

            drag_drop($_REQUEST["id_objet"], $_SESSION["mascotte"]->decorations, $_SESSION["inventaire_environn"], false);

            retourner_succes();
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function jouer() {
        try {
            $_SESSION["utilisateur"]->argent += rand(-1, 1) * (rand(0, 50) * 10);
            $_SESSION["utilisateur"]->argent = max(0, $_SESSION["utilisateur"]->argent);
            retourner_succes(array("argent" => $_SESSION["utilisateur"]->argent));
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function creer_mascotte() {
        try {
            $classe = $_REQUEST["classe"];
            $m = new $classe();

            $m->classe = $classe;
            $m->id_utilisateur = $_SESSION["utilisateur"]->id;
            $m->id_maladie = null;
            $m->id_env_prefere = rand(1, 4);
            $m->id_env_actuel = rand(1, 4);
            $m->nom = $_REQUEST["nom"];
            $m->is_male = ($_REQUEST["sexe"] == "male");
            $m->age = 0;
            $m->bonheur = 100;
            $m->sante = 100;
            $m->faim = 0;
            $m->pourc_maladie = 0;

            $m->save();

            // On charge les donnes de la mascotte
            charger_mascotte();

            retourner_succes();
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }

    function tuer() {
        sleep(3);
        try {
            $_SESSION["mascotte"]->del_complex();
            unset($_SESSION["mascotte"]);
            retourner_succes();
        }
        catch(Exception $ex) {
            retourner_erreur($ex->getMessage());
        }
    }
?>
