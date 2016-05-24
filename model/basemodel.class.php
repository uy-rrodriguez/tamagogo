<?php
require_once("bs/connexionbd.class.php");

abstract class BaseModel {

    public function __construct() {
        //echo "<pre>BaseModel()</pre>";
    }

    public function __set($att, $value) {
        //echo "<pre>". get_class($this) .": __set($att, $value)</pre>";
        $this->$att = $value;
    }

    public function __get($att) {
        //echo "<pre>". get_class($this) .": __get($att)</pre>";

        if (isset($this->$att)) {
            return $this->$att;
        }
        else {
            throw new Exception("L'attribut $att n'existe pas dans la classe ". get_class($this) .".");
        }
    }

	public function __toString() {
        echo "<pre>". get_class($this) .": __toString()</pre>";
	    return var_export(get_object_vars($this), true);
	}


    /*
        Cette fonction fait l'INSERT ou UPDATE d'un objet à partir des noms de propriétés
        recues par paramètre. Le nom de la table est aussi donné.
        On suppose qu'il y a toujours une propriété id.

        $update sert à changer le comportement par défaut, où les objets sont mis à jour
        si l'id est déjà défini (par exemple pour tables qui n'ont pas un id automatique).
    */
    public function save_as($table, $props, $default = true, $is_insert = false) {
        $sql = "";

        try {
            $conn = new ConnexionBD();

            $do_insert = ($default ? !isset($this->id) : $is_insert);

            if ($do_insert) {
                $values = array();
                foreach ($props as $att) {
                    $values[] = $this->$att;
                }

                $sql = "INSERT INTO $table";
                $sql .= " (" . implode(",", $props) . ")";
                $sql .= " VALUES ('" . implode("','", $values) . "')";
            }
            else {
                $sql = "UPDATE $table SET ";
                $set = array();

                foreach ($props as $att) {
                    $value = $this->$att;
                    if ($att != "id" && $value)
                        $set[] = "$att = '" . $value . "'" ;
                }

                $sql .= implode(",", $set);
                $sql .= " WHERE id = " . $this->id;
            }

            $conn->doExec($sql);


            /*  Sans cette modiffication, on recevait une erreur après un UPDATE (Seulement pour PostgreSQL):
             *      Object not in prerequisite state: 7 ERROR: currval of sequence "post_id_seq" is not yet defined in this session
             * Pour les INSERT c'est necessaire.
             */
            if ($do_insert)
                $this->id = $conn->getLastInsertId(strtolower(get_class($this)));

            return $this->id == false ? NULL : $this->id;
        }
        catch(Exception $ex) {
            throw new Exception($ex->getMessage() . ". SQL : $sql");
        }
    }

    /*
        Cette fonction fait l'INSERT ou UPDATE automatique d'un objet à partir de ses propriétés.
    */
    public function save() {
        try {
            return $this->save_as(strtolower(get_class($this)),
                                  array_keys(get_object_vars($this)));
        }
        catch(Exception $ex) {
            //echo "<h1>" . $ex->getMessage() . "</h1>";
            throw $ex;
        }
    }

    public function get($id) {
        //echo "<pre>". get_class($this) .": get($id)</pre>";
        try {
            $conn = new ConnexionBD();
            $sql = "SELECT * FROM " . strtolower(get_class($this)) . " WHERE id = " . $id;
            $res = $conn->doQueryObject($sql, get_class($this));

            if ($res === false || empty($res))
                return null;

            return $res[0];
        }
        catch(Exception $ex) {
            //echo "<h1>" . $ex->getMessage() . "</h1>";
            throw $ex;
        }
    }

    public function getBy($attrib, $value) {
        //echo "<pre>". get_class($this) .": get($id)</pre>";
        try {
            $conn = new ConnexionBD();
            $sql = "SELECT * FROM " . strtolower(get_class($this)) . " WHERE $attrib = " . $value;
            $res = $conn->doQueryObject($sql, get_class($this));

            if ($res === false || empty($res))
                return null;

            return $res[0];
        }
        catch(Exception $ex) {
            //echo "<h1>" . $ex->getMessage() . "</h1>";
            throw $ex;
        }
    }

    public function getAll() {
        try {
            $conn = new ConnexionBD();
            $sql = "SELECT * FROM " . strtolower(get_class($this));
            $res = $conn->doQueryObject($sql, get_class($this));

            if ($res === false || empty($res))
                return null;

            return $res[0];
        }
        catch(Exception $ex) {
            //echo "<h1>" . $ex->getMessage() . "</h1>";
            throw $ex;
        }
    }

    public function del() {
        $sql = "";
        try {
            $conn = new ConnexionBD();
            $sql = "DELETE FROM " . strtolower(get_class($this)) . " WHERE id = " . $this->id;
            $conn->doExec($sql);
        }
        catch(Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }






    /*
    public function save() {
        try {
            //echo "<pre>". get_class($this) .": save()</pre>";

            $conn = new ConnexionBD() ;
            $props = get_object_vars($this);

            if ($this->id) {
                $sql = "UPDATE " . get_class($this) . " SET ";
                $set = array();

                foreach ($props as $att => $value) {
                    if ($att != "id" && $value)
                        $set[] = "$att = '".$value."'" ;
                }

                $sql .= implode(",", $set);
                $sql .= " WHERE id = " . $this->id;
            }
            else {
                $sql = "INSERT INTO " . get_class($this);
                $sql .= " (" . implode(",", array_keys($props)) . ")";
                $sql .= " VALUES ('" . implode("','", array_values($props)) . "')";
            }

            $connection->doExec($sql);

            if (! $this->id)
                $this->id = $connection->getLastInsertId(get_class($this));

            return $this->id == false ? NULL : $this->id;
        }
        catch(Exception $ex) {
            //echo "<h1>" . $ex->getMessage() . "</h1>";
            throw $ex;
        }
    }
    */
}

?>
