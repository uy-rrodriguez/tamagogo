<?php

require_once("basemodel.class.php");

class Environnement extends BaseModel {

    protected id;
    protected nom;
    protected prix;
    protected effets;
    protected decorations;

    public function __construct() {
        echo "<pre>Environnement()</pre>";
    }

    public function ajouterDecoration($decoration) {
        echo "<pre>". get_class($this) .": ajouterDecoration($decoration)</pre>";
    }

    public function supprimerDecoration($decoration) {
        echo "<pre>". get_class($this) .": supprimerDecoration($decoration)</pre>";
    }
}

?>
