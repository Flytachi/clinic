<?php
	include('auth.php');?><?php
	include('../connect.php');
	$id=$_GET['id'];
	$result = $db->prepare("SELECT * FROM supliers WHERE suplier_id= :userid");
	$result->bindParam(':userid', $id);
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>
<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="saveeditsupplier.php" method="post">
<center>
  <h4><i class="icon-edit icon-large"></i>Редактировать</h4></center><hr>
<div id="ac">
<input type="hidden" name="memi" value="<?php echo $id; ?>" />
<span>Название поставщика : </span>
<input type="text" style="width:265px; height:30px;" name="name" value="<?php echo $row['suplier_name']; ?>" /><br>
<span>Адрес : </span>
<input type="text" style="width:265px; height:30px;" name="address" value="<?php echo $row['suplier_address']; ?>" /><br>
<span>Контактное лицо: </span>
<input type="text" style="width:265px; height:30px;" name="cperson" value="<?php echo $row['contact_person']; ?>" /><br>
<span>Телефон.: </span>
<input name="contact" type="text" id="contact" style="width:265px; height:30px;" value="<?php echo $row['suplier_contact']; ?>" /><br>
<span>Р/с.: </span>
<input name="rsh" type="text" id="rsh" style="width:265px; height:30px;" value="<?php echo $row['rsh']; ?>" /><br>
<span>Банк.: </span>
<input name="bank" type="text" id="bank" style="width:265px; height:30px;" value="<?php echo $row['bank']; ?>" /><br>
<span>МФО: </span>
<input name="mfo" type="text" id="mfo" style="width:265px; height:30px;" value="<?php echo $row['mf']; ?>" /><br>
<span>ИНН: </span>
<input name="inn" type="text" id="inn" style="width:265px; height:30px;" value="<?php echo $row['inn']; ?>" /><br>
<span>Заметки: </span>
<textarea style="width:265px; height:80px;" name="note"><?php echo $row['note']; ?></textarea><br>
<div style="float:right; margin-right:10px;">

<button class="btn btn-success btn-block btn-large" style="width:267px;"><i class="icon icon-save icon-large"></i> Сохранить</button>
</div>
</div>
</form>
<?php
}
?>