<?php

use Mixin\Hell;

require_once '../tools/warframe.php';
$session->is_auth();

if ( isset($_POST['model']) ) {
    
    if (class_exists($_POST['model'])) {
        $form = new $_POST['model'];
        unset($_POST['model']);
        
        if (empty($_POST['id'])) {
            $form->set_post($_POST);
            $form->save();
        }else{
            $form->set_post($_POST);
            $form->update();
        }
    }else dd("Модель не найдена!");

}else Hell::error('403');
?>
