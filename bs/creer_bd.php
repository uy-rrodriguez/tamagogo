<?php
    require_once("connexionbd.class.php");

    try {
        echo "Connexion. <br/>";
        $conn = new ConnexionBD();

        echo "Drop tables. <br/>";
        $conn->doExec("DROP TABLE IF EXISTS jeu;");
        $conn->doExec("DROP TABLE IF EXISTS effet_environnement;");
        $conn->doExec("DROP TABLE IF EXISTS effet_objet;");
        $conn->doExec("DROP TABLE IF EXISTS effet;");
        $conn->doExec("DROP TABLE IF EXISTS nourriture;");
        $conn->doExec("DROP TABLE IF EXISTS medicament;");
        $conn->doExec("DROP TABLE IF EXISTS vetement;");
        $conn->doExec("DROP TABLE IF EXISTS decoration;");
        $conn->doExec("DROP TABLE IF EXISTS objet;");
        $conn->doExec("DROP TABLE IF EXISTS monstre;");
        $conn->doExec("DROP TABLE IF EXISTS animal;");
        $conn->doExec("DROP TABLE IF EXISTS humanoide;");
        $conn->doExec("DROP TABLE IF EXISTS env_debloques;");
        $conn->doExec("DROP TABLE IF EXISTS mascotte;");
        $conn->doExec("DROP TABLE IF EXISTS environnement;");
        $conn->doExec("DROP TABLE IF EXISTS maladie;");
        $conn->doExec("DROP TABLE IF EXISTS utilisateur;");

        echo "Creation tables. <br/>";

        echo "> Utilisateur. <br/>";
        $sql = "CREATE TABLE utilisateur (id INTEGER PRIMARY KEY,
                                            nom VARCHAR(20),
                                            motDePasse VARCHAR(50),
                                            email VARCHAR(50),
                                            argent INTEGER,
                                            derniereConnexion INTEGER);";
        $conn->doExec($sql);

        echo "> Maladie. <br/>";
        $sql = "CREATE TABLE maladie (id INTEGER PRIMARY KEY,
                                        nom VARCHAR(50),
                                        coef INTEGER,
                                        pourcInitial INTEGER,
                                        description TEXT);";
        $conn->doExec($sql);

        echo "> Environnement. <br/>";
        $sql = "CREATE TABLE environnement (id INTEGER PRIMARY KEY,
                                            nom VARCHAR(50),
                                            prix INTEGER);";
        $conn->doExec($sql);

        echo "> Mascotte. <br/>";
        $sql = "CREATE TABLE mascotte (id INTEGER PRIMARY KEY,
                                        classe VARCHAR(10),
                                        id_utilisateur INTEGER,
                                        id_maladie INTEGER DEFAULT NULL,
                                        id_envPrefere INTEGER,
                                        id_envActuel INTEGER,
                                        nom VARCHAR(20),
                                        isMale BOOLEAN,
                                        age INTEGER,
                                        bonheur INTEGER,
                                        faim INTEGER,
                                        sante INTEGER,
                                        pourcMaladie INTEGER,
                                        FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id),
                                        FOREIGN KEY (id_maladie) REFERENCES maladie(id),
                                        FOREIGN KEY (id_envPrefere) REFERENCES environnement(id),
                                        FOREIGN KEY (id_envActuel) REFERENCES environnement(id));";
        $conn->doExec($sql);

        echo "> Environnements debloques. <br/>";
        $sql = "CREATE TABLE env_debloques (id_mascotte INTEGER,
                                            id_environnement INTEGER,
                                            FOREIGN KEY (id_mascotte) REFERENCES mascotte(id),
                                            FOREIGN KEY (id_environnement) REFERENCES environnement(id));";
        $conn->doExec($sql);

        echo "> Humanoide. <br/>";
        $sql = "CREATE TABLE humanoide (id INTEGER PRIMARY KEY,
                                        FOREIGN KEY (id) REFERENCES mascotte(id));";
        $conn->doExec($sql);

        echo "> Animal. <br/>";
        $sql = "CREATE TABLE animal (id INTEGER PRIMARY KEY,
                                        FOREIGN KEY (id) REFERENCES mascotte(id));";
        $conn->doExec($sql);

        echo "> Monstre. <br/>";
        $sql = "CREATE TABLE monstre (id INTEGER PRIMARY KEY,
                                        FOREIGN KEY (id) REFERENCES mascotte(id));";
        $conn->doExec($sql);

        echo "> Objet. <br/>";
        $sql = "CREATE TABLE objet (id INTEGER PRIMARY KEY,
                                    id_utilisateur INTEGER DEFAULT NULL,
                                    nom VARCHAR(20),
                                    prix INTEGER,
                                    img VARCHAR(200),
                                    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id));";
        $conn->doExec($sql);

        echo "> Decoration. <br/>";
        $sql = "CREATE TABLE decoration (id INTEGER PRIMARY KEY,
                                         id_mascotte INTEGER DEFAULT NULL,
                                         FOREIGN KEY (id) REFERENCES objet(id),
                                         FOREIGN KEY (id_mascotte) REFERENCES mascotte(id));";
        $conn->doExec($sql);

        echo "> Vetement. <br/>";
        $sql = "CREATE TABLE vetement (id INTEGER PRIMARY KEY,
                                        id_mascotte INTEGER DEFAULT NULL,
                                        FOREIGN KEY (id) REFERENCES objet(id),
                                        FOREIGN KEY (id_mascotte) REFERENCES mascotte(id));";
        $conn->doExec($sql);

        echo "> Medicament. <br/>";
        $sql = "CREATE TABLE medicament (id INTEGER PRIMARY KEY,
                                            FOREIGN KEY (id) REFERENCES objet(id));";
        $conn->doExec($sql);

        echo "> Nourriture. <br/>";
        $sql = "CREATE TABLE nourriture (id INTEGER PRIMARY KEY,
                                            FOREIGN KEY (id) REFERENCES objet(id));";
        $conn->doExec($sql);

        echo "> Effet. <br/>";
        $sql = "CREATE TABLE effet (id INTEGER PRIMARY KEY,
                                    attribut VARCHAR(10),
                                    coef INTEGER);";
        $conn->doExec($sql);

        echo "> Effet-Objet. <br/>";
        $sql = "CREATE TABLE effet_objet (id_objet INTEGER,
                                            id_effet INTEGER,
                                            PRIMARY KEY (id_objet, id_effet),
                                            FOREIGN KEY (id_objet) REFERENCES objet(id),
                                            FOREIGN KEY (id_effet) REFERENCES effet(id));";
        $conn->doExec($sql);

        echo "> Effet-Environnement. <br/>";
        $sql = "CREATE TABLE effet_environnement (id_environnement INTEGER,
                                                    id_effet INTEGER,
                                                    PRIMARY KEY (id_environnement, id_effet),
                                                    FOREIGN KEY (id_environnement) REFERENCES environnement(id),
                                                    FOREIGN KEY (id_effet) REFERENCES effet(id));";
        $conn->doExec($sql);

        echo "> Jeu. <br/>";
        $sql = "CREATE TABLE jeu (id INTEGER PRIMARY KEY,
                                    nom VARCHAR(50),
                                    cout INTEGER,
                                    gain INTEGER,
                                    description TEXT);";
        $conn->doExec($sql);

        echo "Fin. <br/>";
    }
    catch (Exception $ex) {
        echo "Erreur : " . $ex->getMessage() . "<br/>";
    }
?>
