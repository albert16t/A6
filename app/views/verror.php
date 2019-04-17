<?php
namespace A4\App\Views;

use A4\Sys\View;
/**
 * Description of verror
 *
 * @author linux
 */
class vError extends View{
    
    public function __construct($dataView = null,$dataTable=null) {
        parent::__construct($dataView,$dataTable);
        $this->output= $this->render('terror.php');
    }
}
