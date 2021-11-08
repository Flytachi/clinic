<?php
require_once '../../tools/warframe.php';
$session->is_auth();

if ( isset($_GET['pk']) and (in_array($session->session_level, ["master", 1]) or $session->status) ) {

	if ($_GET['pk'] == "master") {
		$_SESSION['session_id'] =$_GET['pk'];
		$_SESSION['session_get_full_name'] = $_GET['pk'];
		$_SESSION['session_level'] = $_GET['pk'];
		$_SESSION['session_division'] = $_GET['pk'];
		unset($_SESSION['status']);
		unset($_SESSION['session_branch']);
	}else {
		$avatar = $db->query("SELECT * FROM users WHERE id = {$_GET['pk']}")->fetch(PDO::FETCH_OBJ);
		$_SESSION['session_id'] = $avatar->id;
		$_SESSION['session_get_full_name'] = ucwords($avatar->last_name." ".$avatar->first_name." ".$avatar->father_name);
		$_SESSION['status'] = $session->session_id;
		$_SESSION['session_level'] = $avatar->user_level;
		$_SESSION['session_division'] = $avatar->division_id;
	}
	
	header("location:/");
}
?>