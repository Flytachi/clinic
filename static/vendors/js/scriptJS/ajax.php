<?php 

	require_once '../../../../tools/warframe.php';

	$id = $_POST['id'];

	$id_user = $_POST['id1']; 

	$sql = "UPDATE chat SET activity = 1 WHERE `id_push` = '$id_user' AND `id_pull` = '$id'";

	$db->query($sql);

	echo json_encode(array('status' => "ok" ));