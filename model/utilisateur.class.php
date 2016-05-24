<?php

require_once("model/basemodel.class.php");

class Utilisateur extends BaseModel {

    /*
    private $id;
    private $nom;
    private $motDePasse;
    private $email;
    private $argent;
    private $derniereConnexion;
    */

    public function __construct() {
        //echo "<pre>Utilisateur()</pre>";
    }

    public static function controllerLogin($email, $mdp) {
        //echo "<pre>". get_class($this) .": controllerLogin($email, $mdp)</pre>";
        try {
            $conn = new ConnexionBD();
            $sql = "SELECT * FROM utilisateur WHERE nom = '" . $_REQUEST["nom"] . "' AND mot_de_passe = '" . $_REQUEST["mdp"] . "'";
            $res = $conn->doQueryObject($sql, "Utilisateur");

            if ($res === false || empty($res))
                return null;

            return $res[0];
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
}

?>
