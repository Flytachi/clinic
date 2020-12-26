<?php

require_once '../tools/warframe.php';

	if (isset($_POST['save'])) {
        $we = read_excel($_FILES['file']['tmp_name']);

       	$mas = $we[0];

       	unset($we[0]);

       	foreach ($we as $key) {
       		for ($i=0; $i < 3; $i++) {

       			$e = $mas[$i];

       			$mas1[$e] = $key[$i];

		        var_dump($mas1);
       		}
       	}

	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>QWE</title>
</head>
<body>

	<form method="post" enctype="multipart/form-data">

		<input type="file" name="file">
		

		<button type="submit" name="save">w</button>

	</form>

</body>
</html>