<?php
require_once '../tools/warframe.php';
$session->is_auth();
$form = new $_GET['model'];
unset($_GET['model']);
$form->delete($_GET['id']);
?>