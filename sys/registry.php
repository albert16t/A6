<?php

namespace A4\Sys;
use A4\Sys\Singleton;

/**
 * Stores app information
 * 
 * Class Registry
 * 
 * @package A4\Sys
 *
 */
class Registry {
    use Singleton;
    private $data=array();
    
    // singleton access
    //private static $instance;
    // if $instance is not instance
    // then creates instance
    // else assigns instance
    /**
     * Assigns class instance
     * @return object
     */
    /*
    static function getInstance(){
        if(!(self::$instance instanceof self)){
            self::$instance=new self();
            
        }
        return self::$instance; 
    }
    */        
    function __construct() {
        $this->data=array();
        $this->loadConf();
    }
    /**
     * Magic methode set
     * @param type $key
     * @param type $value
     */
    function __set($key, $value) {
        if(!array_key_exists($key, $this->data)){
            //$this->data=$value;
            $this->data[$key]=$value;
        }
    }
    
    function __get($key) {
        if($key!=null){
            if(array_key_exists($key, $this->data)){
                return $this->data[$key];
            }else{
                return null;
            }
        }
        return null;
    }
    /**
     * Unset data key or complete data 
     * @param type $key
     */
    function __unset($key=null) {
        if($key!=null){
            if(array_key_exists($key, $this->data)){
                unset($this->data[$key]);
            }
        }else{
            unset($this->data);
        }
    }
    /**
     * loads config file
     * @return void
     */
    function loadConf(){
        $fileConf=APP.'config.json';
        $jsonstr= file_get_contents($fileConf);
        $arrayJson= json_decode($jsonstr);
        foreach ($arrayJson as $key => $value) {
            $this->data[$key]=$value;
            
        }
    }
}
