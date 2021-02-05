<?php
session_start();
$_SESSION['session_id'] = $_GET['slot'];
unset($_GET['slot']);
header("location:/");
?>
