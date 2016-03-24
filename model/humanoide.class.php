<?php

require_once("mascotte.class.php");

class Humanoide extends mascotte {

    private const COEF_BONHEUR = 1;
    private const COEF_FAIM = 1;
    private const COEF_SANTE = 1;
    private const COEF_TOMBER_MALADE = 1;

    public function __construct() {
        echo "<pre>Humanoïde()</pre>";
    }

    public calculerEtat($dernierCalcul) {
        echo "<pre>". get_class($this) .": calculerEtat($dernierCalcul)</pre>";
    }

    public actualiserEtatFinJeu($resultat) {
        echo "<pre>". get_class($this) .": actualiserEtatFinJeu($resultat)</pre>";
    }
}

?>
