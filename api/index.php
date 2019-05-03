<?php
    use Api\Lib\Autoload;
    use Api\Lib\Rest;
        ini_set('display_errors','on');
        define('DS',DIRECTORY_SEPARATOR);
        define('ROOT',realpath(dirname(__FILE__)).DS);
        define('LIB',ROOT.'lib'.DS);
        require_once __DIR__.'/lib/autoload.php';
        $loader=new Autoload();
        $loader->register();
        $loader->addNamespace('Api\Lib','lib');
        $loader->addNamespace('Api\Lib\Controllers','lib/controllers');
        $app=new Rest();