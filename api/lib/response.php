<?php
    namespace Api\Lib;
    use Api\Lib\Responsejson;
    class Response
    {
        public static function create($data,$format){
            switch ($format){
                case 'application/json':
                default:
                    $obj=new Responsejson($data);
                    break;
            }
            return $obj;
        }
    }