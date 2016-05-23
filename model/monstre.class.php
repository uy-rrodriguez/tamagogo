<?php

require_once("mascotte.class.php");

class Monstre extends Mascotte {

    const COEF_BONHEUR = 1;
    const COEF_FAIM = 1;
    const COEF_SANTE = 1;
    const COEF_TOMBER_MALADE = 1;

    public function __construct() {
        //echo "<pre>Monstre()</pre>";
    }

    public function calculerEtat($dernierCalcul) {
        echo "<pre>". get_class($this) .": calculerEtat($dernierCalcul)</pre>";
    }

    public function actualiserEtatFinJeu($resultat) {
        echo "<pre>". get_class($this) .": actualiserEtatFinJeu($resultat)</pre>";
    }
}

?>
