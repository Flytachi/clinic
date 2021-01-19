<?php

	$uploaddir = 'files/';
	$uploadfile = $uploaddir . basename($_FILES['filedata']['name']);

	if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploadfile)) {
	    echo "Файл корректен и был успешно загружен.\n";
	} else {
	    echo "Возможная атака с помощью файловой загрузки!\n";
	}

