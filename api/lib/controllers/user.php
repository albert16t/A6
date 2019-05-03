<?php
    namespace Api\Lib\Controllers;
    use Api\Lib\SPDO;
    class User
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
                    //$sql="SELECT * FROM usuarios";
                    $sql="SELECT id,email,nombre,apellidos FROM usuarios";
                    $stmt=$this->gbd->prepare($sql);
                    $stmt->execute();
                    $rows=$stmt->fetchAll(\PDO::FETCH_ASSOC);
                }else{
                    $sql="SELECT id,email,nombre,apellidos FROM usuarios WHERE id=:id";
                    $stmt=$this->gbd->prepare($sql);
                    $id=$request->parameters;
                    $stmt->bindValue(':id',$id,\PDO::PARAM_INT);
                    $stmt->execute();
                    $rows=$stmt->fetchAll(\PDO::FETCH_ASSOC);
                }
                if($rows==null){
                    return ['msg'=>'User not found'];
                }
                return $rows;
            }
        }
        function post($request=null){
            if($_SERVER['REQUEST_METHOD']!='POST'){
                return array('error'=>'Request not valid');
            }else{
                if(!empty($request->parameters['email'])&&!empty($request->parameters['clave'])&&
                    !empty($request->parameters['nombre'])&& !empty($request->parameters['apellidos'])){
                    $clave = $request->parameters['clave'];
                    $clave_encriptada= password_hash($clave, PASSWORD_DEFAULT);
                    $fecha_actual=date('Y-m-d H:i:s');
                    $sql="INSERT INTO usuarios (email, clave, nombre, apellidos, fecha_creado) ";
                    $sql.="VALUES (:email, :clave, :nombre, :apellidos, :fecha_creado)";
                    $stmt=$this->gbd->prepare($sql);
                    $stmt->bindValue(':email',$request->parameters['email'],\PDO::PARAM_STR);
                    $stmt->bindValue(':clave',$clave_encriptada,\PDO::PARAM_STR);
                    $stmt->bindValue(':nombre',$request->parameters['nombre'],\PDO::PARAM_STR);
                    $stmt->bindValue(':apellidos',$request->parameters['apellidos'],\PDO::PARAM_STR);
                    $stmt->bindValue(':fecha_creado',$fecha_actual,\PDO::PARAM_STR);
                    $result=$stmt->execute();
                    if($result){
                        return ['msg'=>'User created'];
                    }else{
                        return ['msg'=>'Cant create user'];
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
                return ['msg'=>'User not defined'];
            }else{
                $id=$request->parameters;
                $sql="DELETE FROM usuarios WHERE id=:id";
                $stmt=$this->gbd->prepare($sql);
                $stmt->bindValue(':id',$id,\PDO::PARAM_INT);
                if($stmt->execute()){
                    if($stmt->rowCount()!=0){
                        return ['msg'=>'User deleted'];
                    }else{
                        return ['msg'=>'Cant delete user'];
                    }
                }else{
                    return ['msg'=>'Cant delete user'];
                }
            }
        }
        function put($request=null){
            if($_SERVER['REQUEST_METHOD']!='PUT'){
                return array('error'=>'Request not valid');
            }else{
                if(empty($request->parameters['id'])){
                    return ['msg'=>'User not defined'];
                }else{
                    $id=$request->parameters['id'];
                    if(!empty($request->parameters['clave'])){
                        $clave = $request->parameters['clave'];
                        $clave_encriptada= password_hash($clave, PASSWORD_DEFAULT);
                        $request->parameters['clave']=$clave_encriptada;
                    }
                    $fecha_actual=date('Y-m-d H:i:s');
                    $camposUpdate=false;
                    foreach ($request->parameters as $field=>$value){
                        if($field!="id"){
                            $camposUpdate=true;
                            $sql="UPDATE usuarios SET $field=:$field,fecha_act=:fecha_act WHERE id=:id";
                            $stmt=$this->gbd->prepare($sql);
                            $stmt->bindValue(':id',$id,\PDO::PARAM_INT);
                            $parameter=":".$field;
                            $stmt->bindValue($parameter,$value,\PDO::PARAM_STR);
                            $stmt->bindValue(':fecha_act',$fecha_actual,\PDO::PARAM_STR);
                            $result=$stmt->execute();
                            if(!$result) {
                                return ['msg'=>'Error updating user'];
                            }else{
                                if($stmt->rowCount()==0){
                                    return ['msg'=>'Error updating user'];
                                }
                            }
                        }
                    }
                    if($camposUpdate){
                        return ['msg'=>'User updated'];
                    }else{
                        return ['msg'=>'No fields to update'];
                    }
                }
            }
        }
    }