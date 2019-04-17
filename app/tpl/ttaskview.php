<?php

include 'head_common.php';

?>
	<div class="well">

	    <h2><?= $this->tarea['titulo']; ?></h2>
	        <br>
	        <dl>
	            <dt>Descripción</dt>
	            <dd>
	                <?= $this->tarea['descripcion']; ?>
	                &nbsp;
	            </dd>
	            <br>

	            <dt>Estado</dt>
	            <dd>
	                <?php
                        if ($this->tarea['estado']==0){
                            echo "Pendiente";
                        }elseif($this->tarea['estado']==1){
                            echo "Finalizada";
                        }
                        ?>
	                &nbsp;
	            </dd>
	            <br>

	            <dt>Fecha de creación</dt>
	            <dd>
	                <?= $this->tarea['fecha_creado']; ?>
	                &nbsp;
	            </dd>
	            <br>
                    <?php if(!is_null($this->tarea['fecha_act'])){ ?>
	            <dt>Fecha de modificación</dt>
	            <dd>
	                <?= $this->tarea['fecha_act']; ?>
	                &nbsp;
	            </dd>
	            <br>
                    <?php } ?>
	        </dl>
                <br>
                <hr>
                <p>
                <a href="<?= APP_W.'tarea/editar/id_tarea/'.$this->tarea['id']; ?>" class="btn btn-primary btn-md">
                    Editar tarea
                </a>
                </p>
                <p><a href="<?= APP_W.'tarea'?>" class="btn btn-info btn-md">Listado de tareas</a></p>
        </div>
    <?php
        include 'footer_common.php';
        ?>