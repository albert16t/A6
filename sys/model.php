<?php

namespace A4\Sys;

use A4\Sys\Singleton;


class Model {
    use Singleton;
    protected $db;
    protected $stmt;
    // interchange data with controlller
    protected $data;
    
    function __construct() {
        // singleton access to database
        $this->db=DB::getInstance();
    }
    
    public function query($sql){
        $this->stmt= $this->db->prepare($sql);
    }
    
    public function bind($param,$value){
        switch ($value){
            case is_int($value):
                $type=\PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type=\PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type=\PDO::PARAM_NULL;
                break;
            default :
                $type=\PDO::PARAM_STR;
        }
        $this->stmt->bindValue($param,$value,$type);
    }
    
    public function execute(){
        $result= $this->stmt->execute();
        return $result;
    }
    
    public function resultSet(){
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function singleSet(){
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function rowCount(){
        return $this->stmt->rowCount();
    }
    
    public function lastInsertId(){
        return $this->db->lastInsertedId();
    }
    
}
