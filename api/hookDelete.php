<?php

use Mixin\Hell;

require_once '../tools/warframe.php';
$session->is_auth();

if ( isset($_GET['model']) ) {
    
    if (class_exists($_GET['model'])) {

        $model = new $_GET['model'];
        unset($_GET['model']);
        $model->call( 'delete', $_GET );

    }else Hell::error('403');

}else Hell::error('403');

?>