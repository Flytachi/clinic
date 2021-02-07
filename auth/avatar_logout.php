<?php
session_start();
$_SESSION['session_id'] = "master";
unset($_SESSION['master_status']);
header("location:/");
?>
