<?php

	require_once '../../../../tools/warframe.php';

	$id = $_POST['id'];

	unset($_POST['id']);

	Mixin\update('notes', $_POST, $id);