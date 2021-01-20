<?php

	$uploaddir = '../../media/files/';
	$uploadfile = $uploaddir . basename($_FILES['filedata']['name']);

	if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploadfile)) {
		header('Content-Type: application/json');
	    echo json_encode(['file_url' => $uploadfile]);
	} else {
	    echo "Возможная атака с помощью файловой загрузки!\n";
	}

