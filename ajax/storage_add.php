<?php
require_once '../tools/warframe.php';
$session->is_auth();

$form = new StorageSupplyItemsModel();
$form->number = $_GET['number'];
$form->uniq_key = $_GET['uniq_key'];
if (isset($_GET['id'])) {
    $form->not_tr = true;
    $form->get_or_404($_GET['id']);
} else {
    $form->form();
}

?>