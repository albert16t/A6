<?php

namespace A4\App\Views;

/**
 * Description of vtareanueva
 *
 * @author linux
 */

use A4\Sys\View;

class vTaskNew extends View{
    public function __construct($dataView = null, $dataTable = null) {
        parent::__construct($dataView, $dataTable);
        $this->output= $this->render('ttasknew.php');
    }
}
