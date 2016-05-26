<?php

require_once("decoration.class.php");
require_once("vetement.class.php");
require_once("medicament.class.php");
require_once("nourriture.class.php");
require_once("effet.class.php");


class ObjetFactory {
    const PRIX_MIN = 1;
    const PRIX_MAX = 100;
    const FACTEUR_PRIX = 10;
    const DIVISEUR_EFFET = 100;


    /*
        À partir du prix d'un objet, on détermine si quelques effets sont négatifs ou pas.
    */
    private static function is_negatif($prix) {
        $determinant = rand(ObjetFactory::PRIX_MIN - 10, ObjetFactory::PRIX_MAX + 10);

        // Si le déterminant est inférieur au prix, l'effet est positif. Sinon, il est négatif.
        // Comme ca, un objet cher a plus de possibilités d'avoir un effet positif.
        // * FACTEUR_PRIX parce que le prix est multiplié par 10 (pour avoir des chiffres plus sympas).
        return ($determinant * ObjetFactory::FACTEUR_PRIX > $prix);
    }

    /*
        Cette fonction retourne un tableau d'effets à partir du prix.
        Les objets les plus chers apportent plus de bénéfices.
        Les effets dépendent du type d'objet.
    */
    private static function calculer_effets($classe, $prix) {
        // On définit les coéfficients de base pour les effets.
        //
        // On tient compte aussi que quelques effets peuvent être négatifs.
        // Un objet cher a plus de possibilités de ne pas changer négativement
        // l'état. C'est le contraire pour les objets moins chers.
        switch ($classe) {
            case "Decoration":
                $negSante = (ObjetFactory::is_negatif($prix) ? -1 : 1);
                $negMaladie = (ObjetFactory::is_negatif($prix) ? -1 : 1);

                $bases = array("sante"     => 1 * $negSante,
                               "bonheur"   => 3,
                               "faim"      => 0,
                               "maladie"   => -2 * $negMaladie); // Un coeff. négatif sur la maladie est un effet positif
                break;

            case "Vetement":
                $negSante = (ObjetFactory::is_negatif($prix) ? -1 : 1);
                $negMaladie = (ObjetFactory::is_negatif($prix) ? -1 : 1);

                $bases = array("sante"     => 2 * $negSante,
                               "bonheur"   => 5,
                               "faim"      => 0,
                               "maladie"   => -1 * $negMaladie);
                break;

            case "Medicament":
                $negBonheur = (ObjetFactory::is_negatif($prix) ? -1 : 1);
                $negFaim = (ObjetFactory::is_negatif($prix) ? -1 : 1);

                $bases = array("sante"     => 5,
                               "bonheur"   => 2 * $negBonheur,
                               "faim"      => -1 * $negFaim,
                               "maladie"   => -0.5);
                break;

            case "Nourriture":
                $negSante = (ObjetFactory::is_negatif($prix) ? -1 : 1);
                $negBonheur = (ObjetFactory::is_negatif($prix) ? -1 : 1);
                $negMaladie = (ObjetFactory::is_negatif($prix) ? -1 : 1);

                $bases = array("sante"     => 2 * $negSante,
                               "bonheur"   => 2 * $negBonheur,
                               "faim"      => -5,
                               "maladie"   => -1 * $negMaladie);
                break;
        }

        // Chaque coéfficient est multiplié par le prix de l'objet
        foreach ($bases as $key => $b)
            $bases[$key] = $b * $prix / ObjetFactory::DIVISEUR_EFFET;


        // On cree les effets a retourner
        $effets = array();
        foreach ($bases as $key => $b) {
            $e = new Effet();
            $e->attribut = $key;
            $e->coef = intval($b);
            $effets[] = $e;
        }

        return $effets;
    }

    public static function genererObjetsDuMarche() {
        try {
            /*
            // Obtention du dernier id dans Objet
            $conn = new ConnexionBD();
            $sql = "SELECT MAX(id) AS maxid FROM objet";
            $res = $conn->doQuery($sql);

            $maxid = 0;
            if ($res !== false && !empty($res))
                $maxid = $res[0]["maxid"];
            */

            // Creation aleatoire
            $classes = array("Decoration", "Vetement", "Medicament", "Nourriture");
            $objets = array();

            for ($i = 0; $i < 20; $i++) {
                //$maxid++;
                $classe = $classes[rand(0, 3)];

                $obj = new $classe();
                $obj->id = $i; // Cet id est faux, on le changera lors du stockage
                $obj->utilisateur = $_SESSION["utilisateur"];
                $obj->id_utilisateur = $obj->utilisateur->id;
                $obj->prix = rand(ObjetFactory::PRIX_MIN, ObjetFactory::PRIX_MAX) * ObjetFactory::FACTEUR_PRIX;
                $obj->effets = ObjetFactory::calculer_effets($classe, $obj->prix);

                switch ($classe) {
                    case "Decoration":
                        $obj->nom = "Décoration";
                        $obj->img = "img/decoration.png";
                        $obj->id_mascotte = null;
                        break;

                    case "Vetement":
                        $obj->nom = "Vêtement";
                        $obj->img = "img/habiller.png";
                        $obj->id_mascotte = null;
                        break;

                    case "Medicament":
                        $obj->nom = "Médicament";
                        $obj->img = "img/soigner.png";
                        break;

                    case "Nourriture":
                        $obj->nom = "Nourriture";
                        $obj->img = "img/nourriture.png";
                        break;
                }

                $objets[] = $obj;
            }

            return $objets;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
}

?>
