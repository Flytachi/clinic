<?php
require_once '../tools/warframe.php';
$_SESSION['session_id'] = $_GET['pk'];
unset($_SESSION['status']);
header("location:".DIR."/index".EXT);
?>
