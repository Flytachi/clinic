<?php     header("Content-Type: text/html; charset=utf-8");
?>
<?php
	//Start session
	session_start();

	//Check whether the session variable SESS_MEMBER_ID is present or not

	// if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
	// 	header("location: ../index.php");
	// 	exit();
	// }

	if ($_SESSION['session_id']) {
		$_SESSION['SESS_MEMBER_ID'] = $_SESSION['session_id'];
		$_SESSION['SESS_FIRST_NAME'] = "name";
		$_SESSION['SESS_LAST_NAME'] = "admin";
	}
	ini_set('display_errors',0);
error_reporting(E_ALL);
?>
