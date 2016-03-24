<?php

require_once("basemodel.class.php");

class Effet extends BaseModel {

    private id;
    private attribut;
    private coef;

    public function __construct() {
        echo "<pre>Effet()</pre>";
    }
}

?>
