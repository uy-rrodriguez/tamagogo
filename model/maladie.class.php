<?php

require_once("basemodel.class.php");

class Maladie extends BaseModel {

    private id;
    private nom;
    private coef;
    private pourcInitial;
    private description;

    public function __construct() {
        echo "<pre>Maladie()</pre>";
    }
}

?>
