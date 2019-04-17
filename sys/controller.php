<?php

namespace A4\Sys;

use A4\Sys\Registry;


abstract class Controller {
    protected $model;
    protected $view;
    protected $params;
    protected $conf; // object app configuration
    protected $app;
    protected $dataView=array();
    protected $dataTable=array();
    
            
    function __construct($params=null,$dataView=null) {
        $this->params=$params; // es un array
        $this->conf=Registry::getInstance();
        // acces to app data config
        $this->app=(array) $this->conf->app;
        $this->dataView=$dataView;
        $this->addData($this->app);
        
    }
    
    /**
     * Incorpora los datos a dataView si el array no es multinivel
     * Asigna el array a dataTable si el array es multinivel
     * 
     * @param array $array datos a agregar
     * @return void
     */
    protected function addData($array){
        if(is_array($array)){
            if($this->is_single($array)){
                $this->dataView=array_merge((array)$this->dataView,$array);
            }else{
                $this->dataTable=$array;
            }
            if(!empty($this->dataTable)){
                $this->dataView= $this->dataTable;
            }
        }
    }
    
    /**
     * Determina si el array es multinivel o no
     * 
     * @return boolean true si no es un array multinivel, falso si lo es
     */
    protected function is_single($data){
        foreach ($data as $value){
            //if(is_array($data)){
            if(is_array($value)){
                return false;
            }
        }
        return true;
    }
    
    protected function ajax($output){
        if(is_array($output)){
            echo json_encode($output);
        }
    }
    
    /**
     * Muestra un mensaje de error en el controlador
     * 
     * return void
     */
    function error(){
        echo "Error. No es llamable la acción";
    }
    
}
