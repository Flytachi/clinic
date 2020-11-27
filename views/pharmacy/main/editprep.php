<?php 
require_once('auth.php');
?><?php header("Content-Type: text/html; charset=utf-8");?><?php
	include('../connect.php');
	$id=$_GET['id'];
	$result = $db->prepare("SELECT * FROM goods WHERE id= :userid");
	$result->bindParam(':userid', $id);
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>
<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="saveeditprep.php" method="post">
<center>
  <h4><i class="icon-edit icon-large"></i>Редактирование наименования</h4></center>
<hr>
<div id="ac">
<input type="hidden" name="memi" value="<?php echo $id; ?>" />
<span>Наименование : </span>
<input  name="goodname" type="text" Required id="goodname" style="width:265px; height:30px;" value="<?php echo $row['goodname']; ?>"/><br>
<br><br>

<div style="float:right; margin-right:10px;">

<button class="btn btn-success btn-block btn-large" style="width:267px;"><i class="icon icon-save icon-large"></i> Сохранить</button>
</div>
</div>
</form>
<?php
}
?>