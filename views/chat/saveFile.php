<?php

	$filePath  = $_FILES['filedata']['tmp_name'];
	$name = md5_file($filePath);
    $pathPicture = '/files/' . $name . ".txt";

    echo $pathPicture;

	$r = move_uploaded_file($filePath,$pathPicture);

	echo strval($r);

	// var_dump($_FILES);
