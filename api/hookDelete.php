<?php

use Mixin\Hell;

require_once '../tools/warframe.php';
$session->is_auth();

if ( isset($_GET['model']) ) {
    
    importModel($_GET['model']);

    $model = new $_GET['model'];
    unset($_GET['model']);
    $model->call( 'delete', $_GET );

}else Hell::error('403');

?>