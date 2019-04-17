<?php

include 'head_common.php';

?>
            <form action="<?= APP_W.'tarea/agregar'?>" method="POST" id="form-tareas">
            <p>
                <label for="titulo">Título</label>
                <br>
                <input type="text" placeholder="Ingrese el titulo" name="titulo"
                       size="50"
                        value="<?php 
                               if (isset($this->titulo_tarea)){
                                   echo $this->titulo_tarea;
                               }
                               ?>"/>
                <?php 
                if (isset($this->errores['titulo'])){
                    echo '<span class="text-danger">'.$this->errores['titulo'].'</span>';
                } ?>
            </p>
            <p>
                <label for="descripcion">Descripción</label>
                <br>
                <textarea name="descripcion" form="form-tareas"
                      placeholder="Ingrese la descripción" rows="4" cols="50"><?php 
                if (isset($this->descripcion)){
                    echo $this->descripcion;
                }
                ?></textarea>
                <?php 
                if (isset($this->errores['descripcion'])){
                    echo '<span class="text-danger">'.$this->errores['descripcion'].'</span>';
                } ?>
            </p>
            <input type="submit" name="agregar" value="Agregar tarea"/>
        </form>
        <br>
        <hr>
        <p><a href="<?= APP_W.'tarea'?>" class="btn btn-info btn-md">Listado de tareas</a></p>
    <?php
        include 'footer_common.php';
        ?>