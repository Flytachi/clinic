<?php
	include('../connect.php');
	$id=$_GET['id'];
	$result = $db->prepare("DELETE FROM goods WHERE id= :memid");
	$result->bindParam(':memid', $id);
	$result->execute();
	echo "<html><head><META HTTP-EQUIV='Refresh' content ='0; URL=all_prep.php'></head></html>"; 
?>