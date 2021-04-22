<?php
require_once '../tools/warframe.php';
$session->is_auth();

// prit($_POST)
$post = Mixin\clean_form($_POST);
$post = Mixin\to_null($post);
$query = Mixin\update("beds", array('user_id' => $post['user_id']), $post['id']);
echo $_GET['user_id'];
?>
