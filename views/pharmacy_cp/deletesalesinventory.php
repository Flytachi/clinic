<?php

    require_once '../../tools/warframe.php';
	
	$id=$_GET['id'];
	$qty=$_GET['qty'];

	$result = $db->query("DELETE FROM sales_order WHERE transaction_id= ". $id ."");


	header("location: sales_inventory.php");
?>