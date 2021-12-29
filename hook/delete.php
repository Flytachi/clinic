<?php
require_once '../tools/warframe.php';
$session->is_auth();

if ( isset($_GET['model']) ) {
    $form = new $_GET['model'];
    unset($_GET['model']);
    $form->delete($_GET['id']);
}else {
    Mixin\error('403');
}
?>