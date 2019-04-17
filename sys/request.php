<?php

namespace A4\Sys;

use Exception;


class Request {
    static private $query=array();
    
    /**
     * Divido la REQUEST_URI en las cadenas que la forman delimitadas por /
     * generando un array de cadenas del cual elimino el blanco del comienzo
     * y la barra del final
     * 
     */
    static function exploding(){
        //echo  "La URI es: ".$_SERVER['REQUEST_URI'].'<br><br>';
        $array_query= explode('/',$_SERVER['REQUEST_URI']);
        // para quitar el blanco del comienzo
        array_shift($array_query);
        
        array_shift($array_query); // elimina A4 solo para producción
        
        // para quitar barra del final 
        if (end($array_query)==""){
            array_pop($array_query);
        }
        self::$query=$array_query;
    }
    
    /**
     * Quita el primer elemento del array
     * 
     * @return primer elemento del array (elemento eliminado)
     */
    static function extract(){
    //static function extract():?string{        en phpStorm
        return array_shift(self::$query);
    }
    
    /**
     * Extrae un arreglo de parametros de la request URI /par1/val1/par2/val2...
     * Debe haber un número par de elementos para formar el arreglo
     * Si no lo hay, muestra error
     * 
     * @return array asociativo donde cada elemento tiene como clave el 
     * nombre del parámetro y su valor es el valor del parámetro
     */
    static function getParams(){
    //static function getParams():?array{       en phpStorm
        // pares impares
        $result=[];
        
        $cant_elem=count(self::$query);
        if ($cant_elem!=0){
            if (($cant_elem%2)!=0){
                // Lanzo una excepción
                throw new Exception("El número de parámetros es impar");
                //echo "error, el número de parámetros es impar";
                //exit;
            }else{ // el número de parámetros es par
                for ($i=1;$i<=$cant_elem/2;$i++){
                    $indice=array_shift(self::$query);
                    $valor=array_shift(self::$query);

                    $result["$indice"]= $valor;
                }
            }
        }
        return $result;
    }
}
