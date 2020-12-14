<?php 

	require_once '../../../../tools/warframe.php';

	$id = $_POST['id'];

	$id_user = $_POST['id1']; 

	$offset1 = $_POST['offset'];

	$offset2 = $offset1 + $offset1;  

	$sql = "SELECT * FROM (SELECT * FROM `chat` WHERE `id_push` = '$id' AND `id_pull` = '$id_user' OR `id_push` = '$id_user' AND `id_pull` = '$id' ORDER BY id DESC LIMIT $offset1, $offset2 )sub ORDER BY id ASC";

	$all = json_encode($db->query($sql)->fetchAll());

	echo json_encode(array('status' => '2002', 'messages' => $all ));