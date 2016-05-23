<?php
    require_once("connexionbd.class.php");

    try {
        echo "Connexion. <br/>";
        $conn = new ConnexionBD();

        echo "Purge tables. <br/>";
        $sql = "DELETE FROM jeu;
                DELETE FROM effet_environnement;
                DELETE FROM effet_objet;
                DELETE FROM effet;
                DELETE FROM nourriture;
                DELETE FROM medicament;
                DELETE FROM vetement;
                DELETE FROM decoration;
                DELETE FROM objet;
                DELETE FROM monstre;
                DELETE FROM animal;
                DELETE FROM humanoide;
                DELETE FROM env_debloques;
                DELETE FROM mascotte;
                DELETE FROM environnement;
                DELETE FROM maladie;
                DELETE FROM utilisateur;";
        $conn->doExec($sql);

        echo "Insertion dans les tables. <br/>";

        echo "> Utilisateur. <br/>";
        $sql = "INSERT INTO utilisateur (id, nom, motDePasse, email, argent, derniereConnexion)
                VALUES (1, 'pepito', '1', 'uyric.gm@gmail.com', 1200, 0),
                        (2, 'pepito2', '2', 'uyric.gm@gmail.com', 2000, 0),
                        (3, 'pepito3', '3', 'uyric.gm@gmail.com', 500, 0);";
        $conn->doExec($sql);

        echo "> Maladie. <br/>";
        $sql = "INSERT INTO maladie (id, nom, coef, pourcInitial, description)
                VALUES (1, 'Grippe', 5, 70, 'Une grippe commune'),
                       (2, 'Sida', 15, 80, 'Une maladie difficile à soigner'),
                       (3, 'Ver assassin', 20, 50, 'Un verre alien qui bouffe la cervelle en moins de trois heures !'),
                       (4, 'Rhume', 2, 75, 'Juste une petite rhume.');";
        $conn->doExec($sql);

        echo "> Environnement. <br/>";
        $sql = "INSERT INTO environnement (id, nom, prix)
                VALUES (1, 'Chambre', 3000),
                       (2, 'Plage', 5000),
                       (3, 'Salon', 8000),
                       (4, 'Forêt', 6500);";
        $conn->doExec($sql);

        echo "> Mascotte. <br/>";
        $sql = "INSERT INTO mascotte (id, classe, id_utilisateur, id_maladie, id_envPrefere, id_envActuel, nom,
                                        isMale, age, bonheur, faim, sante, pourcMaladie)
                VALUES (1, 'Humanoide', 1, NULL, 2, 1, 'Nicol', true, 21, 40, 60, 70, 30),
                        (2, 'Animal', 2, NULL, 2, 1, 'Cheshire', true, 5, 0, 0, 0, 0),
                        (3, 'Monstre', 3, NULL, 2, 1, 'El Conejo Loco', true, 5, 100, 50, 80, 2);";
        $conn->doExec($sql);

        echo "> Environnements debloques. <br/>";
        $sql = "INSERT INTO env_debloques (id_mascotte, id_environnement)
                VALUES (1, 1);";
        $conn->doExec($sql);

        echo "> Humanoide. <br/>";
        $sql = "INSERT INTO humanoide (id) VALUES (1);";
        $conn->doExec($sql);


        echo "> Animal. <br/>";
        $sql = "INSERT INTO animal (id) VALUES (2);";
        $conn->doExec($sql);

        echo "> Monstre. <br/>";
        $sql = "INSERT INTO monstre (id) VALUES (3);";
        $conn->doExec($sql);

        /*
        echo "> Objet. <br/>";
        $sql = "INSERT INTO objet (id, id_utilisateur, nom, prix, img)
                VALUES (1, 1, 'Hamburgeur');";
        $conn->doExec($sql);

        echo "> Decoration. <br/>";
        $sql = "INSERT INTO decoration (id INTEGER PRIMARY KEY,
                                         id_mascotte INTEGER DEFAULT NULL,
                                         FOREIGN KEY (id) REFERENCES objet(id),
                                         FOREIGN KEY (id_mascotte) REFERENCES mascotte(id));";
        $conn->doExec($sql);

        echo "> Vetement. <br/>";
        $sql = "INSERT INTO vetement (id INTEGER PRIMARY KEY,
                                        id_mascotte INTEGER DEFAULT NULL,
                                        FOREIGN KEY (id) REFERENCES objet(id),
                                        FOREIGN KEY (id_mascotte) REFERENCES mascotte(id));";
        $conn->doExec($sql);

        echo "> Medicament. <br/>";
        $sql = "INSERT INTO medicament (id INTEGER PRIMARY KEY,
                                            FOREIGN KEY (id) REFERENCES objet(id));";
        $conn->doExec($sql);

        echo "> Nourriture. <br/>";
        $sql = "INSERT INTO nourriture (id INTEGER PRIMARY KEY,
                                            FOREIGN KEY (id) REFERENCES objet(id));";
        $conn->doExec($sql);
        */

        /*
        echo "> Effet. <br/>";
        $sql = "INSERT INTO effet (id INTEGER PRIMARY KEY,
                                    attribut VARCHAR(10),
                                    coef INTEGER);";
        $conn->doExec($sql);

        echo "> Effet-Objet. <br/>";
        $sql = "INSERT INTO effet_objet (id_objet INTEGER,
                                            id_effet INTEGER,
                                            PRIMARY KEY (id_objet, id_effet),
                                            FOREIGN KEY (id_objet) REFERENCES objet(id),
                                            FOREIGN KEY (id_effet) REFERENCES effet(id));";
        $conn->doExec($sql);

        echo "> Effet-Environnement. <br/>";
        $sql = "INSERT INTO effet_environnement (id_environnement INTEGER,
                                                    id_effet INTEGER,
                                                    PRIMARY KEY (id_environnement, id_effet),
                                                    FOREIGN KEY (id_environnement) REFERENCES environnement(id),
                                                    FOREIGN KEY (id_effet) REFERENCES effet(id));";
        $conn->doExec($sql);

        echo "> Jeu. <br/>";
        $sql = "INSERT INTO jeu (id INTEGER PRIMARY KEY,
                                    nom VARCHAR(50),
                                    cout INTEGER,
                                    gain INTEGER,
                                    description TEXT);";
        $conn->doExec($sql);
        */

        echo "Fin. <br/>";
    }
    catch (Exception $ex) {
        echo "Erreur : " . $ex->getMessage() . "<br/>";
    }
?>
