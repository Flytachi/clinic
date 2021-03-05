<?php 
	include_once('dbconnect.php');
	if(empty($_POST['scaninput']) == FALSE)
	{
	$barcode = htmlentities($_POST['scaninput']);
		$barcode_check = $con->query("select * from barcode where barcode='$barcode'");
		if($barcode_check->rowCount() > 0)
		{
			while($row = $barcode_check->fetch(PDO::FETCH_OBJ))
			{
				$status = $row->status;
			}
		}
		if($barcode_check->rowCount() > 0 && $status == 'Valid')
		{
			$sell = $con->exec("UPDATE barcode SET status='Invalid' where barcode= '$barcode'");
			if($sell > 0)
			{
				echo "<script> alert('Successfully sold');</script>";
			}
		}else if($barcode_check->rowCount() > 0 && $status == 'Invalid'){
			echo "<script> alert('Item Not Sold');</script>";
		}else{
		echo "<script> alert('Item Not Present....');</script>";
		}
	}else{
		echo "<script> alert('Please Input or Scan Barcode.....');</script>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bootstrap Barcode Scanner Generator</title>
	<link href="Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<style>body{background-image: url("barcode.jpg"); background-repeat: round;}</style>
<body>
<div class="container">
	<div>
		<h1 align="center">Bootstrap Barcode Scanner Generator&nbsp <span  class="glyphicon glyphicon-barcode" aria-hidden="true" class="glyphicon-class"><h1>
	</div><br /><br /><br />
	<div>
	<form action="index.php"  method="post" style="margin-left: 155px;">
		<label>&nbspINPUT / SCAN THE ITEM BARCODE</label><br />
			<input type="text" name="scaninput" class="form-control" onfocus="ON" autocomplete="OFF" style="width: 250px;" placeholder="Input Barcode Number ...">
	</form>
	</div>
</div>
</body>
</html>