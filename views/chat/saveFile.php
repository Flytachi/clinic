<?php

	$uploaddir = '../../media/files/';

	$we = explode(".",$_FILES['filedata']['name']);

	$name = sha1(uniqid()).".".$we[1];

	$uploadfile = $uploaddir . basename($name);

	if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploadfile)) {
		header('Content-Type: application/json');
	    echo json_encode(['file_url' => $uploadfile]);
	} else {
	    echo "Возможная атака с помощью файловой загрузки!\n";
	}

