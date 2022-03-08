<?php
require_once '../tools/warframe.php';
$session->is_auth();

// prit($_POST)
$post = Mixin\clean_form($_POST);
$post = Mixin\to_null($post);
$query = Mixin\update("beds", array('patient_id' => $post['patient_id']), $post['id']);
echo $_GET['patient_id'];
?>
