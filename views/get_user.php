<?php
	
	require_once '../tools/warframe.php';

	$id_user = $_POST['id_user'];

	$parent_id = $_POST['id_patient'];

	// $id_user = 34;

	// $parent_id = 12;	

	$sql = "SELECT vs.id, vs.user_id , us.first_name, vs.parent_id, us.last_name FROM visit vs LEFT JOIN users us ON (us.id = vs.user_id) WHERE vs.parent_id = $parent_id AND vs.user_id = $id_user ";


	$d = $db->query($sql)->fetchAll();

	echo json_encode(array('status' => "ok" , 'queue' => $d ));

?>