<?php
    class Util {

        // Retourne une couleur aleatoire
        public static function randColor() {
            $base = "0123456789ABCDEF";
            $res = "#";
            for ($i = 0; $i < 6; $i++)
                $res .= $base[rand(0, strlen($base)-1)];
            return $res;
        }

    }
?>
