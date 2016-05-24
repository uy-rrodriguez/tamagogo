<?php

require_once("basemodel.class.php");

class Effet extends BaseModel {

    /*
    private id;
    private attribut;
    private coef;
    */

    public function __construct() {
        //echo "<pre>Effet()</pre>";
    }

    // Fonction pour obtenir tous les effets associes a un objet
    public function getByObjet($idObjet) {
        try {
            $conn = new ConnexionBD();
            $sql = "SELECT e.* FROM " . strtolower(get_class($this)) . " AS e";
            $sql .= " INNER JOIN effet_objet eo ON (e.id = eo.id_effet)";
            $sql .= " WHERE eo.id_objet = " . $idObjet;
            $res = $conn->doQueryObject($sql, get_class($this));

            if ($res === false || empty($res))
                return array();

            return $res;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    // Fonction pour obtenir tous les effets associes a un environnement
    public function getByEnvironnement($idEnvironnement) {
        try {
            $conn = new ConnexionBD();
            $sql = "SELECT e.* FROM " . strtolower(get_class($this)) . " AS e";
            $sql .= " INNER JOIN effet_environnement ee ON (e.id = ee.id_effet)";
            $sql .= " WHERE ee.id_environnement = " . $idEnvironnement;
            $res = $conn->doQueryObject($sql, get_class($this));

            if ($res === false || empty($res))
                return array();

            return $res;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
}

?>
