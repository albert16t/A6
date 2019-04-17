<?php
namespace A4\App\Controllers;

use A4\Sys\Controller;
use A4\App\Views\vTask;
use A4\App\Views\vTaskNew;
use A4\App\Views\vTaskView;
use A4\App\Views\vTaskEdit;
use A4\App\Models\mTask;
use A4\Sys\Session;


class Task extends Controller{
    function __construct($params) {
        parent::__construct($params);
    }
    /**
     * Lista de tareas
     */
    function home(){
        //recordación credenciales del usuario
        $id_usuario=Session::get('id_usuario');
        $nombre=Session::get('nombre');
        $apellidos=Session::get('apellidos');
        $message=Session::get('message');
        $typeMessage=Session::get('typeMessage');
        
        if(is_null($id_usuario)){
            $id_usuario=0;
        }
        if(is_null($nombre)){
            $nombre="";
        }
        if(is_null($apellidos)){
            $apellidos="";
        }
        // Borra el mensaje una vez sacado por pantalla
        if(is_null($typeMessage)){
            $typeMessage="";
        }else{
            Session::del('typeMessage');
        }
        if(is_null($message)){
            $message="";
        }else{
            Session::del('message');
        }

        $this->model=new mTask();
        // localizo las tasks del usuario logado
        $tasks= $this->model->listarTareas($id_usuario);
        // Guardo la cantidad
        $quantity= count($tasks);
        // Creamos el titulo para el usuario
        $title="Tareas de: ".$nombre." ".$apellidos;

        $this->addData([
            'page'=>'Tareas',
            'title'=>$title,
            'tasks'=>$tasks,
            'cantTareas'=>$quantity,
            'message'=>$message,
            'typeMessage'=>$typeMessage
        ]);
        $this->view=new vTask($this->dataView, $this->dataTable);
        $this->view->show();
    }



    function ver(){
        // Almacena la identificación de la tarea
        if (isset($this->params['id_tarea'])){
            $id_tarea= $this->params['id_tarea'];
        }else{
            Session::set('message', "No recibo identificación de task");
            Session::set('typeMessage', "danger");
            header("Location: ".URL."task");

        }
        $this->model=new mTask();
        // Busca la tarea y compruebo que es del usuario
        $task=$this->model->verTarea($id_tarea);

        if (empty($task)){
            Session::set('message', "Tarea no encontrada");
            Session::set('typeMessage', "danger");
            header("Location: ".URL."task");
        }else{
            $id_usuario=$task['id_usuario'];
            $id_usuario_sesion=Session::get('id_usuario');
            if ($id_usuario<>$id_usuario_sesion){
                Session::set('message', "La tarea no corresponde con el usuario");
                Session::set('typeMessage', "danger");
                header("Location: ".URL."task");
            }
        }
        $title='Tareas a Hacer';
        $this->addData([
            'page'=>'Ver Tarea',
            'title'=>$title,
            'task'=>$task
        ]);
        $this->view=new vTaskView($this->dataView, $this->dataTable);
        $this->view->show();
    }

    function nueva(){
        
        $title="Nueva tarea";
        
        $this->addData([
            'page'=>'Nueva tarea',
            'title'=>$title
        ]);
        
        $this->view=new vTaskNew($this->dataView, $this->dataTable);
        $this->view->show();
    }
    
    /**
    * Valido los datos para insertar una tarea
    */
    function agregar(){
        $title=filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $descripcion=filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);

        $errors=array();
        // Valido cada campo
        if(!is_null($title) && !empty($title) && $title!=FALSE){
            $longTitle=strlen($title);
            if($longTitle < 5){
                $errors['title']="Debe ser mayor o igual a 5";
            }
            if($longTitle > 20){
                $errors['title']="Debe ser menor o igual a 20";
            }
        }else{
            $errors['title']="Debe ingresar un titulo";
        }
        if(!is_null($descripcion) && !empty($descripcion) && $descripcion!=FALSE){
            if(strlen($descripcion) < 5){
                $errors['descripcion']="Debe ser mayor o igual a 5";
            }
        }else{
            $errors['descripcion']="Debe ingresar una descripción";
        }
        // Si no hay errores
        if (count($errors)==0){
            // Recupero el id
            $id_usuario=Session::get('id_usuario');
            if(is_null($id_usuario)){
                $id_usuario=0;
            }
            $this->model=new mTask();
            // inserto la tarea en la bd
            $result=$this->model->agregarTarea($title,$descripcion,$id_usuario);
            if ($result){ 
                Session::set('message', "Tarea insertada correctamente");
                Session::set('typeMessage', "success");
            }else{
                Session::set('message', "No se pudo insertar la tarea");
                Session::set('typeMessage', "danger");
            }
            header("Location: ".URL."tarea");
        }else{
            // mostrar errores
            $this->addData([
                    'page'=>'Nueva tarea',
                    'title'=>'Nueva tarea',
                    'titulo_tarea'=>$title,
                    'descripcion'=>$descripcion,
                    'errors'=>$errors
            ]);
            $this->view=new vTaskNew($this->dataView, $this->dataTable);
            $this->view->show();
        }
    }

    
    /**
     * Edición de la tarea
     */
    function editar(){

        if (isset($this->params['id_tarea'])){
            $id_tarea= $this->params['id_tarea'];
        }else{
            echo "Necesito el id de la tarea";
            exit;
        }
        $this->model=new mTask();
        $tarea=$this->model->verTarea($id_tarea);
        // Si no encuentro la tarea
        if (empty($tarea)){  
            Session::set('message', "Tarea no encontrada");
            Session::set('typeMessage', "danger");
            header("Location: ".URL."tarea");
        }else{

            $id_usuario=$tarea['id_usuario'];
            $id_usuario_sesion=Session::get('id_usuario');
            if ($id_usuario<>$id_usuario_sesion){
                Session::set('message', "La tarea no pertenece al usuario logueado");
                Session::set('typeMessage', "danger");
                header("Location: ".URL."tarea");
            }
            // controlo que la no esté terminada
            $estado=$tarea['estado'];
            if ($estado==1) {
                Session::set('message', "No puede editar una tarea ya terminada");
                Session::set('typeMessage', "danger");
                header("Location: ".URL."tarea");
            }
        }
        $titulo='Editar tarea';
        $this->addData([
            'page'=>'Editar Tarea',
            'title'=>$title,
            'id_tarea'=>$id_tarea,
            'tarea'=>$tarea
        ]);
        $this->view=new vTaskEdit($this->dataView, $this->dataTable);
        $this->view->show();
    }

    function modificar(){
        $id_tarea=filter_input(INPUT_POST, 'id_tarea');
        $title=filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $descripcion=filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
        $estado=filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);


        // Validaciones( las mismas que cuando creamos una task)
        $errors=array();

        if(!is_null($title) && !empty($title) && $title!=FALSE){

            $longTitle=strlen($title);
            if($longTitle < 5){
                $errors['title']="Debe ser mayor o igual a 5";
            }
            if($longTitle > 20){
                $errors['title']="Debe ser menor o igual a 20";
            }
        }else{
            $errors['title']="Debe ingresar el title de la task";
        }

        if(!is_null($descripcion) && !empty($descripcion) && $descripcion!=FALSE){
            if(strlen($descripcion) < 5){
                $errors['descripcion']="Debe ser mayor o igual a 5";
            }
        }else{
            $errors['descripcion']="Debe ingresar la descripción";
        }

        if(!is_null($estado) && !empty($estado) && $estado!=FALSE){
            if ($estado <> "Pendiente" && $estado <> "Finalizada"){
                $errors['estado']="Debe ingresar un estado válido";
            }
        }else{
            $errors['estado']="Debe ingresar el estado";
        }
        // comprobamos que tienen el mismo id la task original con la que acabamos de modificar
        if(is_null($id_tarea) || empty($id_tarea)){
            $_SESSION['message']="Necesito el id";
            $_SESSION['typeMessage']="danger";
            header("Location: ".URL."task");
        }
        // Si no hay errores
        if (count($errors)==0){
            $id_usuario=Session::get('id_usuario');
            if(is_null($id_usuario)){
                $id_usuario=0;
            }
            $this->model=new mTask();
            // Actualizo los datos
            $result=$this->model->modificarTarea($id_tarea,$title,$descripcion,$estado,$id_usuario);

            if ($result){ 
                Session::set('message', "Modificada correctamente");
                Session::set('typeMessage', "success");
            }else{
                Session::set('message', "No se pudo modificar");
                Session::set('typeMessage', "danger");
            }
            header("Location: ".URL."task");
        }else{
            $task=array();
            $task['title']=$title;
            $task['descripcion']=$descripcion;
            if($estado=="Pendiente"){
                $task['estado']=0;
            }else{
                $task['estado']=1;
            }
            $title='Editar task';
            $this->addData([
                'page'=>'Editar Tarea',
                'title'=>$title,
                'id_tarea'=>$id_tarea,
                'task'=>$task,
                'errors'=>$errors
            ]);
            $this->view=new vTaskEdit($this->dataView, $this->dataTable);
            $this->view->show();
        }
    }
    
    /**
     * Borro la tarea
     */
    function borrar(){
        if (isset($this->params['id_tarea'])){
            $id_tarea= $this->params['id_tarea'];
        }else{
            echo "Necesito el id";
            exit;
        }
        $this->model=new mTask();
        $result=$this->model->borrarTarea($id_tarea);
        if ($result){
            $_SESSION['message']="Eliminada correctamente";
            $_SESSION['typeMessage']="success";
        }else{
            $_SESSION['message']="No se pudo borrar";
            $_SESSION['typeMessage']="danger";
        }
        header("Location: ".URL."tarea");
    }
    

    function cerrarSesion(){
        Session::destroy();  
        header("Location: ".URL."login");
    }
    

    function cerrarUsuario(){
        $this->eliminarCookies();
        $this->cerrarSesion();
    }
    

    private function eliminarCookies(){
        if (isset($_COOKIE['email'])){
            setcookie('email',"", time()-1800,"/A4");
        }
        if (isset($_COOKIE['password'])){
            setcookie('password',"", time()-1800,"/A4");
        }
    }
    
}
