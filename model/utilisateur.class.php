<?php

require_once("basemodel.class.php");

class Utilisateur extends BaseModel {

    private id;
    private nom;
    private mdp;
    private email;
    private argent;
    private derniereConnexion;

    public function __construct() {
        echo "<pre>Utilisateur()</pre>";
    }

    public function controllerLogin($email, $mdp) {
        echo "<pre>". get_class($this) .": controllerLogin($email, $mdp)</pre>";
    }
}

?>
