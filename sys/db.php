<?php
namespace A4\Sys;

use A4\Sys\Registry;

class DB extends \PDO { //implements DBAdapter
    
    use Singleton;
    
    public function __construct() {
        /*$config= Registry::getInstance();
        $dbconf=(array)$config->dbconf;
        //$dsn driver:host=
        $dsn=$dbconf['driver'].':host='.$dbconf['dbhost'].';dbname='.$dbconf['dbname'];
        $username=$dbconf['dbuser'];
        $passwd=$dbconf['dbpass'];
        try{
            parent::__construct($dsn, $username, $passwd);    
        } catch (\PDOException $e) {
            echo "Fallo en la conexion";
            // $e->getMessage();
        }*/
        $config=Registry::getInstance();
        //determines the correct environment in DB
        $strdbconf='dbconf_'.env;
        $dbconf=(array)$config->$strdbconf;

        $dsn=$dbconf['driver'].':host='.$dbconf['dbhost'].';dbname='.$dbconf['dbname'];
        $usr=$dbconf['dbuser'];
        $pwd=$dbconf['dbpass'];
        parent::__construct($dsn,$usr,$pwd);
        
    }
    
    function connect(){
        
    }
    function disconnect(){
        
    }
}
