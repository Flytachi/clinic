<?php
require_once '../tools/warframe.php';
$session->is_auth();

if ( isset($_GET['model']) ) {
    if ( isset($_GET['id']) ) {
        $form = new $_GET['model'];
        unset($_GET['model']);
        $form->get_or_404($_GET['id']);
    }else{
        $form = new $_GET['model'];
        unset($_GET['model']);
        $form->{$_GET['form']}();
        unset($_GET['form']);
    }
}else {
    Mixin\error('403');
}
?>
