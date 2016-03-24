<?php

abstract class BaseModel {

    public function __construct() {
        echo "<pre>BaseModel()</pre>";
    }

    public function __set($att, $value) {
        echo "<pre>". get_class($this) .": __set($att, $value)</pre>";
        $this->$att = $value;
    }

    public function __get($att) {
        echo "<pre>". get_class($this) .": __get($att)</pre>";

        if (property_exists(get_class($this), $att)) {
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

	public function save() {
        echo "<pre>". get_class($this) .": save()</pre>";

        /*
		$connection = new dbconnection() ;
		if($this->id)
		{
		  $sql = "update jabaianb.".get_class($this)." set " ;
		  $set = array() ;
		  foreach($this->data as $att => $value)
			if($att != 'id' && $value)
			  $set[] = "$att = '".$value."'" ;
		  $sql .= implode(",",$set) ;
		  $sql .= " where id=".$this->id ;
		}
		else
		{
		  $sql = "insert into jabaianb.".get_class($this)." " ;
		  $sql .= "(".implode(",",array_keys($this->data)).") " ;
		  $sql .= "values ('".implode("','",array_values($this->data))."')" ;
		}
		$connection->doExec($sql) ;


		/
		 *  Sans cette modiffication, on recevait une erreur après un UPDATE:
		 *      Object not in prerequisite state: 7 ERROR: currval of sequence "post_id_seq" is not yet defined in this session
		 /
		if (! $this->id)
    		$this->id = $connection->getLastInsertId("jabaianb.".get_class($this)) ;

		return $this->id == false ? NULL : $this->id ;
        */
	}

    public function get($id) {
        echo "<pre>". get_class($this) .": get($id)</pre>";
    }

    public function getAll() {
        echo "<pre>". get_class($this) .": getAll()</pre>";
    }
}

?>
