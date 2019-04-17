<?php
include 'head_common.php';
?>
        <div><?php 
                if(isset($this->messageError)&&!empty($this->messageError))
                { 
                    echo($this->messageError);
                }
                ?>
        </div>
        <br>
        <hr>
        <p><a href="<?= URL.'home'?>" class="btn btn-primary btn-md">Cancelar</a></p>
        </div>
    </body>
</html>