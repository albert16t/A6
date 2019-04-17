<?php
namespace A4\App\Controllers;

use A4\Sys\Controller;
use A4\App\Views\vReg;
use A4\App\Models\mReg;
use A4\Sys\Session;


class Reg extends Controller {
    
   function __construct($params) {
       parent::__construct($params);
       $this->addData([
            'page'=>'Registro',
            'title'=>'Registro'
        ]);
        $this->model=new mReg();
        $this->view=new vReg($this->dataView, $this->dataTable);
   }
   
   function home(){
        $this->view->show();
   }
   
   /**
    * Valida los datos para poder añadirlos a la bd
    * 
    */
   function reg(){
        // Recupero los datos ingresados por el formulario
        $nombre=filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $apellidos=filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
        $email=filter_input(INPUT_POST, 'email');
        $password=filter_input(INPUT_POST, 'password');

        
        // Validaciones de los campos
        $errors=array();
        
        // nombre
        if(!is_null($nombre) && !empty($nombre) && $nombre!=FALSE){
            if(strlen($nombre) > 20){
                $errors['nombre']="Debe ser menor a 20";
            }
        }else{
            $errors['nombre']="Ingrese un nombre";
        }

        // apellidos
        if(!is_null($apellidos) && !empty($apellidos) && $apellidos!=FALSE){
            if(strlen($apellidos) > 150){
                $errors['apellidos']="Debe ser menor a 150";
            }
        }else{
            $errors['apellidos']="Ingrese apellidos";
        }

        // mail
        if(!is_null($email) && !empty($email)){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email']="Correo inválido";
            }
        }else{
            $errors['email']="Ingrese un correo";
        }

        // password
        if(!is_null($password) && !empty($password)){
            // encriptación del password
            $passwordEncrypt= password_hash($password, PASSWORD_DEFAULT);
        }else{
            $errors['password']="Ingrese la contraseña";
        }
        
        // Si todos ellos son válidos:
        if (count($errors)==0){
            // inserción de los campos
            $result=$this->model->reg($nombre,$apellidos,$email,$passwordEncrypt);
            // guardo mensaje con resultado de la inserción en variable de sesión
            if ($result){ 
                Session::set('message', "Usuario registrado");
                Session::set('typeMessage', "success");
            }else{ 
                Session::set('message', "No se pudo insertar el usuario");
                Session::set('typeMessage', "danger");
            }
            header("Location: ".URL."home");

        }else{
            // mostrar errores
            $this->addData([
                    'page'=>'Registro',
                    'title'=>'Registro de usuarios',
                    'nombre'=>$nombre,
                    'apellidos'=>$apellidos,
                    'email'=>$email,
                    'errors'=>$errors
            ]);
            $this->view=new vReg($this->dataView, $this->dataTable);
            $this->view->show();
        }
    }
    
    /*
     * Validación del mail
     * 
     */
   function valemail(){
       $email=filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
       if(!$email){
           $this->ajax(['msg'=>'Email inválido']);
       }else{
           $res= $this->model->validate_email($email);
            if($res){
                $this->ajax(['msg'=>'Email en uso']);
            }else{
                $this->ajax(['msg'=>'Email válido']);
            }
       }
       
   }
    
}
