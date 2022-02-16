<?php

use Mixin\Hell;

require_once '../tools/warframe.php';
$session->is_auth();

if ( isset($_GET['model']) ) {
    
    importModel($_GET['model']);

    $model = new $_GET['model'];
    unset($_GET['model']);
    if ( isset($_GET['id']) ) $model->call( 'update', $_GET, $_POST, $_FILES );
    else $model->call( 'save', $_GET, $_POST, $_FILES );

}else Hell::error('403');

?>