<?php

    error_reporting(E_ALL);
    ini_set('display_errors','On');
    
    use \A4\Sys\Kernel;
    use \A4\Sys\Autoload;
    use \A4\Sys\Session;

    require_once 'x.inic.php';

// predefine constants
    /*define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', realpath(__DIR__).DS);
    define('APP', ROOT.'app'.DS);
    define('URL', '/A4/');*/
    
    // config file
    require_once __DIR__.'/sys/autoload.php';



    // metodos de autocarga
    $load=new Autoload();
    $load->register();
    //$load->addNamespace(prefix: 'Framework\Sys', base_dir: 'sys');
    $load->addNamespace('A4\Sys','sys');
    $load->addNamespace('A4\App','app');
    $load->addNamespace('A4\App\Controllers','app/controllers');
    $load->addNamespace('A4\App\Models','app/models');
    $load->addNamespace('A4\App\Views','app/views');
    

    Session::init();

    Kernel::init();
