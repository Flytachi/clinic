<?php

use Mixin\Hell;

require '../tools/warframe.php';
$session->is_auth();

if ( isset($_GET['model']) ) {
    

    // if (isset($_SESSION['CSRFTOKEN']) and isset($_POST['csrf_token']) and hash_equals($_SESSION['CSRFTOKEN'], $_POST['csrf_token'])) {

        // unset($_SESSION['CSRFTOKEN']);
        // unset($_POST['csrf_token']);
        importModel($_GET['model']);

        $model = new $_GET['model'];
        unset($_GET['model']);
        if ( isset($_GET['id']) ) $model->call( 'update', $_GET, $_POST, $_FILES );
        else $model->call( 'save', $_GET, $_POST, $_FILES );

    // } else Hell::error('403');
    

}else Hell::error('403');

?>