<?php

namespace A4\Sys;
use A4\Sys\Request;
use A4\App\Controllers\Error;
use Exception;


class kernel {
    /**
      * This methode allows initializa application
      * Frontend Controller
      * @return void
      */

    static private $controller;
    static private $action;
    static private $params;
    

    public static function init(){
        // Procesa la REQUEST_URI
        Request::exploding();
        // Extracción de atributos
        // Extrae el nombre del controlador
        self::$controller= Request::extract();
        // Extrae la acción del controlador
        self::$action=Request::extract();
        try {
            // Extrae los parámetros 
            self::$params=Request::getParams();
            // Call to Router applying 
            self::router();
            //controller and action    
        } catch (Exception $ex) {
            echo 'Excepción capturada: '.$ex->getMessage();
        }
    }
    
    static function getFileCont(){
    //static function getFileCont():?string{        en phpStorm
        // recibe la variable controller
        // select default action and controller
        // home es la accion y el controlador por defecto
        self::$controller=(self::$controller!="")?self::$controller:'home';
        self::$action=(self::$action!="")?self::$action:'home';
        
        //$filename= strtolower(self::$controller).'Controller.php';
        $filename= strtolower(self::$controller).'.php';
        
        //$fileroute=       **** completar
        //$fileroute="app/controllers/".$filename;
        $fileroute=APP."controllers/".$filename;
        
        return $fileroute;
    }

    /**
     * Busca el controlador y la acción
     * Instancia el controlador y llama a la acción
     * 
     * @return void
     */
    static function router(){
        // el controlador por defecto es home
        self::$controller=(self::$controller!="")?self::$controller:'home';
        // la acción por defecto es home
        self::$action=(self::$action!="")?self::$action:'home';
        
        $class='\\A4\App\Controllers\\'.ucfirst(self::$controller);
        if(class_exists($class)){
            // Instacio la clase 
            // Reemplaza el nombre controlador por objeto clase controlador
            self::$controller= new $class(self::$params);
            // new object calls action
            // action call
            if(is_callable(array(self::$controller,self::$action))){
                // si existe ese método dentro de ese controller, llamarlo
                call_user_func(array(self::$controller, self::$action));
            }else{ // is not callable
                // lanzar el método error del controlador
                // No es llamable la acción
                self::$action='error';
                call_user_func(array(self::$controller, self::$action));
            }
        }else{ // si la clase no existe
            // Instancio la clase Error con el atributo mensaje
            $mensaje="No existe el controlador: ".self::$controller;
            self::$params['mensaje']=$mensaje;
            self::$controller=new Error(self::$params);
            self::$action="home";
            call_user_func(array(self::$controller, self::$action));
        }
    }
}
