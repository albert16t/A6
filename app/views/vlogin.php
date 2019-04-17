<?php

namespace A4\App\Views;

/**
 * Description of vlog
 *
 * @author linux
 */

use A4\Sys\View;

class vLogin extends View{
    public function __construct($dataView = null, $dataTable = null) {
        parent::__construct($dataView, $dataTable);
        $this->output= $this->render('tlog.php');
    }
}
