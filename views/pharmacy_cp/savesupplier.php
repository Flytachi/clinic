<?php

	require_once '../../tools/warframe.php';

	function insert($tb, $post)
	{
	    global $db;
	    $col = implode(",", array_keys($post));
	    $val = ":".implode(", :", array_keys($post));
	    $sql = "INSERT INTO $tb ($col) VALUES ($val)";
	    try{
	        $stm = $db->prepare($sql)->execute($post);
	        return $stm;
	    }
	    catch (\PDOException $ex) {
	        return $ex->getMessage();
	    }
	}


	var_dump($_POST);

	insert('supliers', $_POST);

	header("location: customer.php");
?>