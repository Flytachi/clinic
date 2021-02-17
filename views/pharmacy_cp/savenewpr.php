<?php

	require_once '../../tools/warframe.php';

	function insert($tb, $post)
	{
	    global $db;
	    $col = implode(",", array_keys($post));
	    $val = ":".implode(", :", array_keys($post));
	    // $dd = implode("', '", array_values($post));
	    // echo "INSERT INTO $tb ($col) VALUES ($dd)";
	    $sql = "INSERT INTO $tb ($col) VALUES ($val)";
	    try{
	        $stm = $db->prepare($sql)->execute($post);
	        return $stm;
	    }
	    catch (\PDOException $ex) {
	        return $ex->getMessage();
	    }
	}


	if (!empty($_POST['goodname'])) {
		insert('goods', $_POST);
	}

	header("location: all_prep.php");
?>