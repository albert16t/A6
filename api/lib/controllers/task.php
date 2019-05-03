<?php
    namespace Api\Lib\Controllers;
    use Api\Lib\SPDO;
    class Task 
    {
        protected $gbd;
        function __construct()
        {
            $this->gbd=SPDO::singleton();
        }
        function get($request=null){
            if($_SERVER['REQUEST_METHOD']!='GET'){
                return ['error' => 'Request not valid'];
            }
            else{
                if($request->parameters==null){
                    $sql="SELECT id,id_usuario,titulo,estado,fecha_creado,fecha_act FROM tareas";
                    $stmt=$this->gbd->prepare($sql);
                    $stmt->execute();
                    $rows=$stmt->fetchAll(\PDO::FETCH_ASSOC);
                }else{
                    $sql="SELECT id,id_usuario,titulo,estado,fecha_creado,fecha_act FROM tareas WHERE id=:id";
                    $stmt=$this->gbd->prepare($sql);
                    $id=$request->parameters;
                    $stmt->bindValue(':id',$id,\PDO::PARAM_INT);
                    $stmt->execute();
                    $rows=$stmt->fetchAll(\PDO::FETCH_ASSOC);
                }
                if($rows==null){
                    return ['msg'=>'Task not found'];
                }
                return $rows;
            }
        }
        function post($request=null){
            if($_SERVER['REQUEST_METHOD']!='POST'){
                return array('error'=>'Request not valid');
            }else{
                if(!empty($request->parameters['id_usuario']) && !empty($request->parameters['titulo']) &&
                    !empty($request->parameters['descripcion'])){
                    $estado=0;
                    $fecha_actual=date('Y-m-d H:i:s');
                    $sql="INSERT INTO tareas (id_usuario, titulo, descripcion, estado, fecha_creado) ";
                    $sql.="VALUES (:id_usuario, :titulo, :descripcion, :estado, :fecha_creado)";
                    $stmt=$this->gbd->prepare($sql);
                    $stmt->bindValue(':id_usuario',$request->parameters['id_usuario'],\PDO::PARAM_INT);
                    $stmt->bindValue(':titulo',$request->parameters['titulo'],\PDO::PARAM_STR);
                    $stmt->bindValue(':descripcion',$request->parameters['descripcion'],\PDO::PARAM_STR);
                    $stmt->bindValue(':estado',$estado,\PDO::PARAM_INT);
                    $stmt->bindValue(':fecha_creado',$fecha_actual,\PDO::PARAM_STR);
                    $result=$stmt->execute();
                    if($result){
                        return ['msg'=>'Task created'];
                    }else{
                        return ['msg'=>'Cant create task'];
                    }
                }else{
                    return ['msg' => 'Parameter missing'];
                }
            }
        }
        function delete($request=null){
            if($_SERVER['REQUEST_METHOD']!='DELETE'){
                return array('error'=>'Request not valid');
            }
            if($request->parameters==null){
                return ['msg'=>'Task not defined'];
            }else{
                $id=$request->parameters;
                $sql="DELETE FROM tareas WHERE id=:id";
                $stmt=$this->gbd->prepare($sql);
                $stmt->bindValue(':id',$id,\PDO::PARAM_INT);
                if($stmt->execute()){
                    if($stmt->rowCount()!=0){
                        return ['msg'=>'Task deleted'];
                    }else{
                        return ['msg'=>'Cant delete task'];
                    }
                }else{
                    return ['msg'=>'Cant delete task'];
                }
            }
        }
        function put($request=null){
            if($_SERVER['REQUEST_METHOD']!='PUT'){
                return array('error'=>'Request not valid');
            }else{
                if(empty($request->parameters['id'])){
                    return ['msg'=>'Task not defined'];
                }else{
                    $id=$request->parameters['id'];
                    $fecha_actual=date('Y-m-d H:i:s');
                    $camposUpdate=false;
                    foreach ($request->parameters as $field=>$value){
                        if($field!="id"){
                            $camposUpdate=true;
                            $sql="UPDATE tareas SET $field=:$field,fecha_act=:fecha_act WHERE id=:id";
                            $stmt=$this->gbd->prepare($sql);
                            $stmt->bindValue(':id',$id,\PDO::PARAM_INT);
                            $parameter=":".$field;
                            if($field=="estado"){
                                if ($value=="Pendiente"){
                                    $value=0;
                                }elseif($value=="Finalizada"){
                                    $value=1;
                                }else{
                                    return ['msg'=>'Estado invalido'];
                                }
                                $stmt->bindValue($parameter,$value,\PDO::PARAM_INT);
                            }else{
                                $stmt->bindValue($parameter,$value,\PDO::PARAM_STR);
                            }
                            $stmt->bindValue(':fecha_act',$fecha_actual,\PDO::PARAM_STR);
                            $result=$stmt->execute();
                            if(!$result) {
                                return ['msg'=>'Error updating task'];
                            }else{
                                if($stmt->rowCount()==0){
                                    return ['msg'=>'Error updating task'];
                                }
                            }
                        }
                    }
                    if($camposUpdate){
                        return ['msg'=>'Task updated'];
                    }else{
                        return ['msg'=>'No fields to update'];
                    }
                }
            }
        }
    }