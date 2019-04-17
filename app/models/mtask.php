<?php

namespace A4\App\Models;

use A4\Sys\Model;


class mTask extends Model{
    public function __construct() {
        parent::__construct();
    }

    function listarTareas($id_usuario){
        $sql="SELECT id,title,descripcion,estado,fecha_creado,fecha_act FROM tareas "
                . "WHERE id_usuario=:id_usuario ORDER BY fecha_creado DESC";
        $this->query($sql);
        $this->bind(":id_usuario",$id_usuario);
        $result= $this->execute();

        if ($result){
                $array_tareas=$this->resultSet();
        }else{ 
            die("Error en listar las tareas");
        }
        return $array_tareas;
    }

    function agregarTarea($title, $descripcion, $id_usuario){
        // preparo la sentencia para insertar registro en la tabla tareas
        $sql="INSERT INTO tareas(id_usuario,title,descripcion,estado,fecha_creado)
                VALUES(:id_usuario,:title,:descripcion,:estado,:fecha_creado)";
        $this->query($sql);
        // ligamos parametros mysqli con variables php
        $estado=0;
        $fecha_actual=date('Y-m-d H:i:s');
        $this->bind(":id_usuario",$id_usuario);
        $this->bind(":title",$title);
        $this->bind(":descripcion",$descripcion);
        $this->bind(":estado",$estado);
        $this->bind(":fecha_creado",$fecha_actual);
        // ejecutar sentencia
        $result= $this->execute();
        if($result){
            return true;
        }else{
            return false;
        }
    }

    function verTarea($id_tarea){
        $sql="SELECT id_usuario,id,title,descripcion,estado,fecha_creado,fecha_act FROM tareas WHERE id=:id_tarea";
        $this->query($sql);
        $this->bind(":id_tarea",$id_tarea);
        $result= $this->execute();
        $datos_tarea=array();
        if ($result){
            if($this->rowCount()!=0){
                $datos_tarea= $this->singleSet();
            }
        }
        return $datos_tarea;
    }

    function modificarTarea($id_tarea,$titulo,$descripcion,$estado,$id_usuario){
        $fecha_actual=date('Y-m-d H:i:s');
        if ($estado=="Pendiente"){
            $estado_act=0;
        }elseif($estado=="Finalizada"){
            $estado_act=1;
        }
        // modifica
        $sql="UPDATE tareas SET title=:title,descripcion=:descripcion,estado=:estado,fecha_act=:fecha_act "
                . "WHERE id=:id_tarea";
        $this->query($sql);
        $this->bind(":title",$title);
        $this->bind(":descripcion",$descripcion);
        $this->bind(":estado",$estado_act);
        $this->bind(":fecha_act",$fecha_actual);
        $this->bind(":id_tarea",$id_tarea);

        $result= $this->execute();
        if($result){
            if($this->rowCount()!=0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }    
    }

    function borrarTarea($id_tarea){
        $sql="DELETE from tareas WHERE id=:id_tarea";
        $this->query($sql);
        $this->bind(":id_tarea",$id_tarea);

        $result= $this->execute();
        if($result){
            if($this->rowCount()!=0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
