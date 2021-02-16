<?php
// configuration
include('../connect.php');

// new data
$id = $_POST['memi'];
$a = $_POST['goodname'];
// query
$sql = "UPDATE goods 
        SET goodname=?
		WHERE id=?";
$q = $db->prepare($sql);
$q->execute(array($a,$id));
header("location: all_prep.php");

?>