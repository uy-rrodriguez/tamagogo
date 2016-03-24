<?php

require_once("basemodel.class.php");

abstract class Mascotte extends BaseModel {

    // Attributs qui ne changeront jamais
    protected id;
    protected nom;
    protected isMale;

    // Etat
    protected age;
    protected bonheur;
    protected faim;
    protected sante;
    protected pourcMaladie;

    // Maladie (cet objet sera non null si la mascotte est malade)
    protected maladieActuelle;

    // Liste de vêtements
    protected vetements;

    // Environnements
    protected envActuel;
    protected envPrefere;
    protected envDebloques;


    protected function __construct() {
        echo "<pre>Mascotte()</pre>";
    }

    abstract public calculerEtat($dernierCalcul);
    abstract public actualiserEtatFinJeu($resultat);

    protected calculerEtat($dernierCalcul, $coefBonheur, $coefFaim, $coefSante, $coefTomberMalade) {
        echo "<pre>". get_class($this) ."calculerEtat($dernierCalcul, $coefBonheur, $coefFaim, $coefSante, $coefTomberMalade)</pre>";
    }

    public nourrir($nourriture) {
        echo "<pre>". get_class($this) .": nourrir($nourriture)</pre>";
    }

    public soigner($medicament) {
        echo "<pre>". get_class($this) .": soigner($medicament)</pre>";
    }

    public tuer() {
        echo "<pre>". get_class($this) .": tuer()</pre>";
    }

    public habiller($vetement) {
        echo "<pre>". get_class($this) .": habiller($vetement)</pre>";
    }

    public deshabiller($vetement) {
        echo "<pre>". get_class($this) ."deshabiller($vetement)</pre>";
    }
}

?>
