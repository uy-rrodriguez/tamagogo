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


    // On redéfinit le stockage. On stocke séparamment la classe de base et son fils
    public function save_update($is_insert) {
        $sql = "";

        try {
            // Stockage de la classe mère
            $vars = array("classe", "id_utilisateur", "id_maladie", "id_env_prefere", "id_env_actuel", "nom",
                            "is_male", "age", "bonheur", "faim", "sante", "pourc_maladie");

            $this->save_as("mascotte", $vars, false, $is_insert);


            // On stocke si c'est un INSERT ou si, lors d'un UPDATE, dans $vars il y a plus de proprietes que seulement l'id.
            if ($is_insert) {
                // Recuperation du nouveau id
                $conn = new ConnexionBD();
                $this->id = $conn->getLastInsertId("mascotte");

                // Stockage des donnees du fils
                $vars = array("id");
                $this->save_as(strtolower(get_class($this)), $vars, false, true);
            }

            else {
                // Stockage des donnees du fils. Pour l'instant on ne stocke rien si c'est un UPDATE, les fils
                // n'ont pas d'attributs specifiques.
                $vars = array("id");
                if (count($vars) > 1)
                    $this->save_as(strtolower(get_class($this)), $vars, false, false);
            }
        }
        catch(Exception $ex) {
            throw new Exception($ex->getMessage() . ". SQL : $sql");
        }
    }

    public function save() {
        $this->save_update(true);
    }

    public function update() {
        $this->save_update(false);
    }


    // Suppression de la mascotte et de tout ce qui est lie
    public function del_complex() {
        $sql = "";
        try {
            // Classe concrete
            $this->del();

            // Objets associes
            if (isset($this->vetements))
                foreach($this->vetements as $o)
                    $o->del_complex();

            if (isset($this->decorations))
                foreach($this->decorations as $o)
                    $o->del_complex();

            // Classe abstracte
            $conn = new ConnexionBD();
            $sql = "DELETE FROM mascotte WHERE id = " . $this->id;
            $conn->doExec($sql);
        }
        catch(Exception $ex) {
            throw new Exception($ex->getMessage() . ". SQL : $sql");
        }
    }
}

?>
