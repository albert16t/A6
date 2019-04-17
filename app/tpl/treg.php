<?php

include 'head_common.php';
                
?>
        <form id="form-reg" class="form-horizontal text-center" action="<?= APP_W.'reg/reg'?>" method="POST" >
            <p>
                <label for="nombre">Nombre</label>
                <br>
                <input type="text" placeholder="Ingrese su nombre" id="nombre-reg" name="nombre" 
                       size="50"
                        value="<?php 
                               if (isset($this->nombre)){
                                   echo $this->nombre;
                               }
                               ?>"/>
                <?php 
                if (isset($this->errors['nombre'])){
                    echo '<span class="text-danger">'.$this->errores['nombre'].'</span>';
                } ?>
            </p>
            <p>
                <label for="apellidos">Apellidos</label>
                <br>
                <input type="text" placeholder="Ingrese sus apellidos" id="apellidos-reg" name="apellidos"
                       size="50"
                        value="<?php 
                               if (isset($this->apellidos)){
                                   echo $this->apellidos;
                               }
                               ?>"/>
                <?php 
                if (isset($this->errors['apellidos'])){
                    echo '<span class="text-danger">'.$this->errores['apellidos'].'</span>';
                } ?>
            </p>
            <p>
                <label for="email">Correo electrónico</label>
                <br>
                <input type="email" placeholder="Ingrese su correo" id="email-reg" name="email"
                       size="50"
                        value="<?php 
                               if (isset($this->email)){
                                   echo $this->email;
                               }
                               ?>"/>
                <?php 
                if (isset($this->errors['email'])){
                    echo '<span class="text-danger">'.$this->errores['email'].'</span>';
                } ?>    
            </p>
            <p>
                <label for="password">Contraseña</label>
                <br>
                <input type="password" placeholder="Ingrese su contraseña" id="clave-reg" name="password"
                       size="50"/>
                <?php 
                if (isset($this->errors['password'])){
                    echo '<span class="text-danger">'.$this->errores['password'].'</span>';
                } ?>
            </p>
            
            <input type="submit" name="enviar" class="btn btn-primary btn-lg" value="Registrar usuario"/>

        </form>
        <br>
        <div class="alert alert-danger" col-sm-offset-2 col-sm-8 id="msg"></div>
        <br>
        <hr>
        <p><a href="<?= APP_W.'home'?>" class="btn btn-danger btn-md">Cancelar</a></p>
        </div>
