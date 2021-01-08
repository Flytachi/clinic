<?php

	require_once '../tools/warframe.php';

	$id = $_POST['id'];


	$sql = "SELECT vs.id, vs.user_id , us.first_name, vs.parent_id, us.last_name FROM visit vs LEFT JOIN users us ON (us.id = vs.user_id) WHERE vs.parent_id = $id AND vs.accept_date IS NULL AND vs.completed IS NULL ORDER BY vs.priced_date ASC";

	$sql1 = "SELECT vs.accept_date, vs.user_id, vs.parent_id, us.first_name, us.last_name FROM visit vs LEFT JOIN users us ON (us.id = vs.user_id) WHERE vs.parent_id = $id AND vs.accept_date IS NOT NULL AND vs.completed IS NULL ORDER BY vs.id DESC LIMIT 1 ";

	$d = $db->query($sql)->fetchAll();

	$s = $db->query($sql1)->fetchAll();

	$mas = json_encode($d);

	echo json_encode(array('status' => "ok" , 'queue' => $d , "reception" => $s ));

?>
