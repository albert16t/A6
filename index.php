<?php


    error_reporting(E_ALL);
    ini_set('display_errors','On');
    
    use \A4\Sys\Kernel;
    use \A4\Sys\Autoload;
    use \A4\Sys\Session;
    use \A4\Sys\Registry;

    require_once 'x.inic.php';
    require_once __DIR__.'/sys/autoload.php';
// predefine constants
    //define('DS', DIRECTORY_SEPARATOR);
    //define('ROOT', realpath(__DIR__).DS);
    //define('APP', ROOT.'app'.DS);
    define('URL', '/A4/');
    
    // config file
    /*

    try{
        $pdo = new PDO("mysql:host=amilia.cesnuria.com;dbname=amilia_todo","amilia_todo2","linuxlinux");
    }catch(PDOException $e){
        echo $e->getMessage();
    }*/

    /*
    $stmt=$pdo->prepare('SELECT * FROM usuarios');
    $stmt->execute();
    var_dump($stmt);*/


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
