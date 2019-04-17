<?php
namespace A4\App\Controllers;

use A4\Sys\Controller;
use A4\App\Views\vLogin;
use A4\App\Models\mLogin;
use A4\Sys\Session;


class Login extends Controller{
    function __construct($params) {
        parent::__construct($params);
        
        $this->addData([
            "page"=>'Login',
            'title'=>'Inicia sesión'
        ]);
        $this->model=new mLogin();
        $this->view=new vLogin($this->dataView, $this->dataTable);
    }
    
    function home(){
        // Si hay un usuario logeado voy a mostrar sus tareas
        if(!is_null(Session::get('id_usuario'))){
            header("Location: ".URL."tarea");

        }
        $this->view->show();
    }
    
    /**
     * Valida las credenciales del usuario
     * 
     */
    function log(){

        $email=filter_input(INPUT_POST, 'email');
        $password=filter_input(INPUT_POST, 'password');
        $recordar=filter_input(INPUT_POST, 'recordar');

        $errors=array();
        
        // Validación del mail
        if(!is_null($email) && !empty($email)){
            if (isset($_COOKIE['email']) && $_COOKIE['email']!=$email) {
            }else{
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errors['email']="Email invalido";
                }    
            }
            
        }else{
            $errors['email']="Ingrese un correo ";
        }
        // Validación del password
        if(is_null($password) || empty($password)){
            $errors['password']="Ingrese la contraseña";
        }
        // Una vez válidos..
        if (count($errors)==0){

            $row=$this->model->validUser($email,$password);
            
            // Si existe
            if (count($row)>0){  
                // opción marcada para recordar en el equipo
                if(!is_null($recordar) && $recordar=="Si"){
                    $this->saveCookies($email, $password);
                }
                // guardo las credenciales
                Session::set('id_usuario', $row[0]['id']);
                Session::set('email', $row[0]['email']);
                Session::set('password', $row[0]['password']);
                Session::set('nombre', $row[0]['nombre']);
                Session::set('apellidos', $row[0]['apellidos']);

                // listado de tareas
                header("Location: ".URL."tarea");

                //rutas a utilizar
                //header("Location: /A4/tarea");  production
                //header("Location: /tarea");  developer

            }else{

                $errors['password']="Contraseña o usuario inválidos";
                $this->addData([
                    "page"=>'Login',
                    'title'=>'Inicia sesión',
                    'email'=>$email,
                    'errors'=>$errors
                ]);
                $this->model=new mLogin();
                $this->view=new vLogin($this->dataView, $this->dataTable);
                $this->view->show();
            }
        }else{
            // mostrar el formulario con los errores
            $this->addData([
                "page"=>'Login',
                'title'=>'Inicia sesión',
                'email'=>$email,
                'errors'=>$errors
            ]);
            $this->model=new mLogin();
            $this->view=new vLogin($this->dataView, $this->dataTable);
            $this->view->show();
        }
        
    }
    
    /**
     * Guarda mail y passwod
     * 
     * @param string $email correo electrónico
     * @param string $password contraseña
     */
    private function saveCookies($email, $clave){

        setcookie('email',$email, time()+1800,"/A4");
        setcookie('password', $clave, time()+1800,"/A4");

    }
    
}
