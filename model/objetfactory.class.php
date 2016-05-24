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

        for ($i = 0; $i < 20; $i++) {
            $cls = $classes[rand(0, 3)];

            $obj = new $cls();
            $obj->id = $i;
            $obj->prix = rand(5, 100) * 10;
            $obj->effets = array();

            switch ($cls) {
                case "Decoration":
                    $obj->nom = "Décoration";
                    $obj->img = "img/decoration.png";
                    break;

                case "Vetement":
                    $obj->nom = "Vêtement";
                    $obj->img = "img/habiller.png";
                    break;

                case "Medicament":
                    $obj->nom = "Médicament";
                    $obj->img = "img/soigner.png";
                    break;

                case "Nourriture":
                    $obj->nom = "Nourriture";
                    $obj->img = "img/nourriture.png";
                    break;
            }


            $objets[] = $obj;
        }

        return $objets;
    }
}

?>
