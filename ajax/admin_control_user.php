<?php
require_once '../tools/warframe.php';
$session->is_auth();

// prit($_GET)
$post = Mixin\clean_form($_GET);
$post = Mixin\to_null($post);
$query = Mixin\update("patients", array('status' => $post['status']), $post['id']);
echo $_GET['status'];
?>
