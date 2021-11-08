<?php
require_once '../tools/warframe.php';
$session->is_auth();

if ( isset($_GET['model']) ) {

    if (class_exists($_GET['model'])) {
        $form = new $_GET['model'];
        unset($_GET['model']);
        $form->delete($_GET['id']);
    }else dd("Модель не найдена!");

}else Mixin\error('403');
?>