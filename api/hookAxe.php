<?php

use Mixin\Hell;

require '../tools/warframe.php';
$session->is_auth();

if ( isset($_GET['model']) ) {

    importModel($_GET['model']);
    
    $model = new $_GET['model'];
    unset($_GET['model']);
    $model->call('axe', $_GET, $_POST, $_FILES);

}else Hell::error('403');

?>