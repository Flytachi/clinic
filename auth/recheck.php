<?php
require_once '../tools/warframe.php';
$_SESSION['session_id'] = $_GET['slot'];
unset($_GET['slot']);
header("location:/");
?>
