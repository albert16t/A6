<?php

namespace Api\Lib;
class SPDO extends \PDO
{
    static $instance;
    function __construct()
    {
        $dbConf=$this->getConfig();
        $driver=$dbConf['driver'];
        $dbhost=$dbConf['dbhost'];
        $dbname=$dbConf['dbname'];
        $dsn="$driver:dbname=$dbname;host=$dbhost";
        $usr=$dbConf['dbuser'];
        $pwd=$dbConf['dbpass'];
        try{
            parent::__construct($dsn, $usr, $pwd);
        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }
    function getConfig(){
        $fileConf=ROOT.'config.json';
        $jsonstr= file_get_contents($fileConf);
        $arrayJson= json_decode($jsonstr);
        $arrayConfig=array();
        foreach ($arrayJson as $key => $value) {
            $arrayConfig[$key]=$value;
        }
        return (array)$arrayConfig['dbconf'];
    }
    static function singleton(){
        if(!(self::$instance) instanceof self){
            self::$instance=new self();
        }
        return self::$instance;
    }
    
}