<?php

	require_once '../../../tools/warframe.php';

	$id = $_POST['id'];

	unset($_POST['id']);

	Mixin\delete('notes', $id);