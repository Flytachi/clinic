<?php
require_once '../tools/warframe.php';
is_auth();
if ($_GET['id']) {
    $form = new $_GET['model'];
    unset($_GET['model']);
    $form->get_or_404($_GET['id']);
}
?>
