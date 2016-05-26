<?php


define ('HOST', 'localhost') ;
define ('USER', 'root'  ) ;
define ('PASS', '' ) ;
define ('DB', 'tamagogo' ) ;
/*
define ('HOST', 'pedago02a.univ-avignon.fr') ;
define ('USER', 'uapv1602799'  ) ;
define ('PASS', 'cFHJEJ' ) ;
define ('DB', 'etd' ) ;
*/

class ConnexionBD
{
  private $link, $error ;

  public function __construct()
  {
    $this->link = null;
    $this->error = null;
    try {
        // Connexion par PDO
        //$this->link = new PDO( "sqlite:tamagogo.db" );
        //$this->link = new PDO( "pgsql:host=" . HOST . ";dbname=" . DB . ";user=" . USER . ";password=" . PASS );

        $this->link = new PDO( "mysql:host=" . HOST . ";dbname=" . DB, USER, PASS );
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
	catch( PDOException $e ) {
        $this->error =  $e->getMessage();
        throw $e;
    }
  }

  public function getLastInsertId($table) {
    //return $this->link->lastInsertId($att."_id_seq");   // PostgreSQL
    return $this->doQuery("SELECT MAX(id) AS maxid FROM $table")[0]["maxid"];    // MySQL
  }

  public function doExec($sql) {
    $prepared = $this->link->prepare( $sql );
    return $prepared->execute();
  }

  public function doQuery($sql) {
    $prepared = $this->link->prepare($sql);
    $prepared->execute();
    $res = $prepared->fetchAll( PDO::FETCH_ASSOC );

    return $res;
  }

  public function doQueryObject($sql,$className) {
    $prepared = $this->link->prepare($sql);
    $prepared->execute();
    $res = $prepared->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $className);

    return $res;
  }

  public function __destruct() {
    $this->link = null;
  }
}
