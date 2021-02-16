<?php
	include('../connect.php');
	$id=$_GET['id'];
	$result = $db->prepare("DELETE FROM products WHERE product_id= :memid");
	$result->bindParam(':memid', $id);
	$result->execute();
	echo "<html><head><META HTTP-EQUIV='Refresh' content ='1; URL=products.php'></head></html>"; 
?>