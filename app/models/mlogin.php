<?php

namespace A4\App\Models;

use A4\Sys\Model;


class mLogin extends Model{
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Valida el usuario y su password con la bd
     */
    function validUser($email, $password){
        // consulta en sql
        $sql="SELECT id,clave,nombre,apellidos FROM usuarios WHERE email=:email";
        $this->query($sql);
        $this->bind(":email",$email);
        $result= $this->execute();
        // guardo los resultados
        $row=array();
        if($result){
            $datos_usuario= $this->singleSet();
            // verifico contraseñas
            $iguales= password_verify($password, $datos_usuario['password']);
            if ($iguales){
                $row[]=array(
                    'id'=>$datos_usuario['id'],
                    'email'=>$email,
                    'password'=>$datos_usuario['password'],
                    'nombre'=>$datos_usuario['nombre'],
                    'apellidos'=>$datos_usuario['apellidos']
                );    
            }
        }
        return $row;
    }    
}
