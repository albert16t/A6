<?php

namespace X;

//require_once __DIR__.'/sys/autoload.php';


define('DS',DIRECTORY_SEPARATOR);
define('ROOT',realpath(__DIR__).DS);
// to acces to filesystem
define('APP',ROOT.'app'.DS);
define('BASE',$_SERVER['SERVER_NAME']);

define('APP_W',root());
define('env',env());
/**
 * determines the public root
 * @return string
 *
 *
 */
function root(){

    if((dirname($_SERVER['PHP_SELF']))==='/'){
        return '/';
    }else{
        return dirname($_SERVER['PHP_SELF']).'/';
    }
}
function env(){
    if ($_SERVER['HTTP_HOST']=='172.17.0.2'){
        return 'pro';
    }else{
        return 'dev';
    }
}