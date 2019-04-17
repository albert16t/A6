<?php

namespace A4\Sys;


class Session {
    
    /**
     * Inicia una nueva sesión o reanuda la existente
     * Almacena código de la sesión actual en la variable de sesión id
     */
    static function init(){
        session_start();
        self::set('id', session_id());
    }
    
    /**
     * Asigna una valor a una variable de sesión
     * $_SESSION es un array asociativo que contiene variables de sesión
     * 
     * @param type $key clave de la variable a asignar
     * @param type $value valor de la variable a asignar
     */
    static function set($key,$value){
        $_SESSION[$key]=$value;
        
    }
    
    /**
     * Recupera el valor de una variable de sesión
     * Si no existe la variable en el array, devuelve null
     * 
     * @param type $key clave de la variable a recuperar
     * @return type valor de la variable con esa clave
     */
    static function get($key){
        if(self::exists($key)){
            return $_SESSION[$key];
        }else{
            return null;
        }
    }
    
    /**
     * Verifica si existe una variable de sesión 
     * 
     * @param type $key clave de la variable a verificar
     * @return boolean
     */
    private static function exists($key){
        if(array_key_exists($key, $_SESSION)){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Destruye una variable de sessión
     * 
     * @param type $key clave de la variable a destruir
     */
    static function del($key){
        if(self::exists($key)){
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * Destruye toda la información registrada de la sesión
     */
    static function destroy(){
        session_destroy();
    }
}
