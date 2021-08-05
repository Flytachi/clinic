<?php
require_once '../../tools/warframe.php';
if ($session->session_id == "avatar") {
	$session->is_auth();
} else {
	$session->is_auth("master");
}

if ( isset($_GET['pk']) ) {
    $avatar = $db->query("SELECT * FROM users WHERE id = {$_GET['pk']}")->fetch(PDO::FETCH_OBJ);
	$_SESSION['session_id'] = $avatar->id;
	$_SESSION['session_get_full_name'] = ucwords($avatar->last_name." ".$avatar->first_name." ".$avatar->father_name);
	$_SESSION['status'] = $session->session_login;
	$_SESSION['session_level'] = $avatar->user_level;
	$_SESSION['session_division'] = $avatar->division_id;
	header("location:/");
}
?>