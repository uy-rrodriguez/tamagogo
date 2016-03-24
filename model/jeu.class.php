<?php

require_once("basemodel.class.php");

class Jeu extends BaseModel {

    private id;
    private nom;
    private cout;
    private gain;
    private description;

    public function __construct() {
        echo "<pre>Jeu()</pre>";
    }
}

?>
