<?php

include 'head_common.php';

if ($this->quantity==0){
    echo "<p>No tienes tareas creadas aún</p>";
}    
else{
?>
        <div class="col-md-12">
            <div class="table-responsive">
                <p>
                    Total: <span id="total"><?= $this->quantity;?></span>
                </p>

                <br>					
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Estado</th>
                            <th>Fecha de creación</th>
                            <th>Fecha de modificación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($this->tareas as $tarea){ ?>
                        <tr data-id="id_usuario">
                            <td><?= $tarea['titulo']?></td>
                            <td>
                                <?php 
                                if($tarea['estado']==0){
                                    echo "<strong>Pendiente</strong>";
                                }elseif($tarea['estado']==1){
                                    echo "<strong>Finalizada</strong>";
                                } 
                                ?>    
                            </td>
                            <td><?= $tarea['fecha_creado']?></td>
                            <td><?= $tarea['fecha_act']?></td>
                            
                            <td class="actions">
                                <a href="<?= APP_W.'tarea/ver/id_tarea/'.$tarea['id']?>" class="btn btn-sm btn-info">
                                    Ver
                                </a>

                                <a href="<?= APP_W.'tarea/editar/id_tarea/'.$tarea['id']?>" class="btn btn-sm btn-primary">
                                    Edit
                                </a>

                                <a href="<?= APP_W.'tarea/borrar/id_tarea/'.$tarea['id']?>" class="btn btn-sm btn-danger btn-delete">
                                    Borrar
                                </a>
                            </td>
                        </tr>
                    <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php }  ?>

    <hr>
    <p><a href="<?= APP_W.'tarea/nueva'?>" class="btn btn-primary btn-md">Nueva tarea</a></p>
    <?php
        include 'footer_common.php';
        ?>