<?php
require_once '../tools/warframe.php';
is_auth();
$form = new $_POST['model'];
unset($_POST['model']);

if (!$_POST['id']) {
    $form->set_post($_POST);
    $form->save();
}else{
    $pk = $_POST['id'];
    unset($_POST['id']);
    $form->set_post($_POST);
    $form->update($pk);
}
?>
