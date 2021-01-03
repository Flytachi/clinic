<?php
	
	require_once '../tools/warframe.php';

	$id_user = $_POST['id_user'];

	$id_patient = $_POST['id_patient'];


	$sql = "SELECT vs.user_id , us.first_name, vs.parent_id, us.last_name FROM visit vs LEFT JOIN users us ON (us.id = vs.user_id) WHERE vs.parent_id = $id_patient AND vs.user_id = $id_user ";


	$d = $db->query($sql)->fetchAll();

	echo json_encode(array('status' => "ok" , 'user' => $d ));

?>