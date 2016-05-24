<?php

require_once("basemodel.class.php");
require_once("effet.class.php");

abstract class Objet extends BaseModel {

    /*
    protected $id;
    protected $nom;
    protected $prix;
    protected $effets;
    protected $img;
    */

    public function __construct() {
        //echo "<pre>Objet()</pre>";
    }

    // On redéfinit le stockage. On stocke séparamment la classe de base et son fils
    public function save_update($is_insert) {
        $sql = "";

        try {
            // Stockage de la classe mère
            $vars = array("nom", "prix", "img");
            if (isset($this->utilisateur)) {
                $vars[] = "id_utilisateur";
                $this->id_utilisateur = $this->utilisateur->id;
            }

            $this->save_as("objet", $vars, false, $is_insert);


            // On stocke si c'est un INSERT ou si, lors d'un UPDATE, dans $vars il y a plus de proprietes que seulement l'id.
            if ($is_insert) {
                // Recuperation du nouveau id
                $conn = new ConnexionBD();
                $this->id = $conn->getLastInsertId("objet");

                // Stockage des donnees du fils
                $vars = array("id");
                if (isset($this->mascotte)) {
                    $vars[] = "id_mascotte";
                    $this->id_mascotte = $this->mascotte->id;
                }
                $this->save_as(strtolower(get_class($this)), $vars, false, $is_insert);

                // Stockage des effets
                foreach($this->effets as $effet) {
                    $effet->save();

                    // Stockage de la relation Effet-Objet
                    $sql = "INSERT INTO effet_objet (id_effet, id_objet)";
                    $sql .= " VALUES (" . $effet->id . ", " . $this->id . ")";
                    $conn->doExec($sql);
                }
            }

            else if (count($vars) > 1) {
                // Stockage des donnees du fils
                $vars = array("id");
                if (isset($this->mascotte)) {
                    $vars[] = "id_mascotte";
                    $this->id_mascotte = $this->mascotte->id;
                }
                $this->save_as(strtolower(get_class($this)), $vars, false, $is_insert);
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


    // Fonction pour obtenir tous les objets associes a l'utilisateur
    public function getByUtilisateur($idUtilisateur) {
        try {
            $conn = new ConnexionBD();
            $sql = "SELECT * FROM " . strtolower(get_class($this));
            $sql .= " INNER JOIN objet USING (id)";
            $sql .= " WHERE id_utilisateur = " . $idUtilisateur;
            $res = $conn->doQueryObject($sql, get_class($this));

            if ($res === false || empty($res))
                return null;

            // S'il y a des objets, on charge les effets
            foreach($res as $obj) {
                $obj->effets = (new Effet())->getByObjet($obj->id);
            }

            return $res;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }


    // Suppression d'un objet et des effets associes
    public function del_complex() {
        $sql = "";
        try {
            // Effet-Objet
            $conn = new ConnexionBD();
            $sql = "DELETE FROM effet_objet WHERE id_objet = " . $this->id;
            $conn->doExec($sql);

            // Effet
            foreach($this->effets as $effet)
                $effet->del();

            // Objet concret
            $this->del();

            // Objet abstract
            $sql = "DELETE FROM objet WHERE id = " . $this->id;
            $conn->doExec($sql);
        }
        catch(Exception $ex) {
            throw new Exception($ex->getMessage() . ". SQL : $sql");
        }
    }

}

?>
