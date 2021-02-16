<?php
	require_once('auth.php');
?><?php
session_start();
include('../connect.php');
$a = $_POST['newpr'];


// query
$sql = "INSERT INTO goods
 (goodname) VALUES (:a)";
$q = $db->prepare($sql);
$q->execute(array(':a'=>$a));
header("location: products.php");

?>