<?php

require_once("basemodel.class.php");

abstract class Objet extends BaseModel {

    protected id;
    protected nom;
    protected prix;
    protected effets;

    protected function __construct() {
        echo "<pre>Objet()</pre>";
    }
}

?>
