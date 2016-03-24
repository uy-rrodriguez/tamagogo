<?php

require_once("decoration.class.php");
require_once("vetement.class.php");
require_once("medicament.class.php");
require_once("nourriture.class.php");

static class ObjetFactory {

    public static genererObjetsDuMarche() {
        echo "<pre>". get_class($this) .": genererObjetsDuMarche()</pre>";
    }
}

?>
