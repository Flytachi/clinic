<?php
session_start();
$_SESSION['session_id'] = $_GET['pk'];
unset($_SESSION['status']);
header("location:/");
?>
