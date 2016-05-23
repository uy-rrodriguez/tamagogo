<?php

require_once("basemodel.class.php");

abstract class Mascotte extends BaseModel {

    /*
    // Attributs qui ne changeront jamais
    protected id;
    protected nom;
    protected isMale;

    // Etat
    protected age;
    protected bonheur;
    protected faim;
    protected sante;
    protected pourcMaladie;

    // Maladie (cet objet sera non null si la mascotte est malade)
    protected maladieActuelle;

    // Liste de vêtements
    protected vetements;

    // Environnements
    protected envActuel;
    protected envPrefere;
    protected envDebloques;
    */


    public function __construct() {
        //echo "<pre>Mascotte()</pre>";
    }

    abstract public function calculerEtat($dernierCalcul);
    abstract public function actualiserEtatFinJeu($resultat);

    /*
    protected function calculerEtat($dernierCalcul, $coefBonheur, $coefFaim, $coefSante, $coefTomberMalade) {
        echo "<pre>". get_class($this) ."calculerEtat($dernierCalcul, $coefBonheur, $coefFaim, $coefSante, $coefTomberMalade)</pre>";
    }
    */

    public function nourrir($nourriture) {
        echo "<pre>". get_class($this) .": nourrir($nourriture)</pre>";
    }

    public function soigner($medicament) {
        echo "<pre>". get_class($this) .": soigner($medicament)</pre>";
    }

    public function tuer() {
        echo "<pre>". get_class($this) .": tuer()</pre>";
    }

    public function habiller($vetement) {
        echo "<pre>". get_class($this) .": habiller($vetement)</pre>";
    }

    public function deshabiller($vetement) {
        echo "<pre>". get_class($this) ."deshabiller($vetement)</pre>";
    }

    public function getByUtilisateur($idUtilisateur) {
        try {
            $conn = new ConnexionBD();
            $sql = "SELECT mascotte.* FROM " . strtolower(get_class($this)) . " INNER JOIN mascotte USING(id)
                    WHERE id_utilisateur = " . $idUtilisateur;
            $res = $conn->doQueryObject($sql, get_class($this));

            if ($res === false || empty($res))
                return null;

            return $res[0];
        }
        catch(Exception $ex) {
            //echo "<h1>" . $ex->getMessage() . "</h1>";
            throw $ex;
        }
    }

    public static function getClasseByUtilisateur($idUtilisateur) {
        try {
            $conn = new ConnexionBD();
            $sql = "SELECT classe FROM mascotte
                    WHERE id_utilisateur = " . $idUtilisateur;
            $res = $conn->doQuery($sql);

            if ($res === false || empty($res))
                return null;

            return $res[0]["classe"];
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
}

?>
