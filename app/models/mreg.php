<?php

namespace A4\App\Models;

use A4\Sys\Model;


class mReg extends Model{
    public function __construct() {
        parent::__construct();
    }
    /**
     * Inserción de registros(usuarios)
     */
    function reg($nombre, $apellidos, $email, $password){
        $sql="INSERT INTO usuarios(email,password,nombre,apellidos,fecha_creado)
                VALUES(:email,:password,:nombre,:apellidos,:fecha_creado)";
        $this->query($sql);
        // guardo fecha actual
        $fecha_actual=date('Y-m-d H:i:s');
        $this->bind(":email",$email);
        $this->bind(":password",$password);
        $this->bind(":nombre",$nombre);
        $this->bind(":apellidos",$apellidos);
        $this->bind(":fecha_creado",$fecha_actual);
        // ejecutar sentencia
        $result= $this->execute();
        if($result){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Verifica si el mail ya existe
     */
    function validate_email($email){
        try{
            $sql="SELECT id FROM usuarios WHERE email=:email";
            $this->query($sql);
            $this->bind(":email",$email);
            $result= $this->execute();
            if($result){
                $res= $this->rowCount();
            }else{
                echo "Error al validar email";
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        if($res==1){
            return true;
        }else{
            return false;
        }
       
    }
    
}
