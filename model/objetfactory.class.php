<?php

require_once("decoration.class.php");
require_once("vetement.class.php");
require_once("medicament.class.php");
require_once("nourriture.class.php");

class ObjetFactory {

    public static function genererObjetsDuMarche() {
        //echo "<pre>". get_class($this) .": genererObjetsDuMarche()</pre>";
        $classes = array("Decoration", "Vetement", "Medicament", "Nourriture");
        $objets = array();

        for ($i = 0; $i < 40; $i++) {
            $cls = $classes[rand(0, 3)];

            $obj = new $cls();
            $obj->id = $i;
            $obj->nom = "Lalala";
            $obj->prix = 150;
            $obj->effets = array();
            $obj->img = "img/faim.png";

            $objets[] = $obj;
        }

        return $objets;
    }
}

?>
