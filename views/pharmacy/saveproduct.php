<?php
	namespace Mixin;
	
	require_once '../../tools/warframe.php';

	is_auth(4);

	insert('products', $_POST);

	header("location: products.php");
?>