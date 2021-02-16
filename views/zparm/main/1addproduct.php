<?php
	require_once('auth.php');
?><link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="saveproduct.php" method="post">
<center>
  <h4><i class="icon-plus-sign icon-large"></i> Приходный лист</h4></center>
<hr>
<div id="ac">
<p><span>Название : </span>
  <input type="text" style="width:265px; height:30px;" name="code" ><br>
  <span>Производитель : </span>
  <input type="text" style="width:265px; height:30px;" name="gen" Required/><br>
  <span>Серия : </span>
  <textarea style="width:265px; height:50px;" name="name"> </textarea>
  <br>
  <span>Дата получения: </span>
  <input type="date" style="width:265px; height:30px;" name="date_arrival" /><br>
  <span>Срок годности : </span>
  <input type="date" value="<?php echo date ('M-d-Y'); ?>" style="width:265px; height:30px;" name="exdate" /><br>
  <span>Цена продажи : </span>
  <input type="text" id="txt1" style="width:265px; height:30px;" name="price" onkeyup="sum();" Required><br>
  <span>Цена прихода : </span>
  <input type="text" id="txt2" style="width:265px; height:30px;" name="o_price" onkeyup="sum();" Required><br>
  <span>Прибыль : </span>
  <input type="text" id="txt3" style="width:265px; height:30px;" name="profit" readonly><br>
  <span>Поставщик : </span>
  <select name="supplier"  style="width:265px; height:30px; margin-left:-5px;" >
    <option></option>
    <?php
	include('../connect.php');
	$result = $db->prepare("SELECT * FROM supliers");
		$result->bindParam(':userid', $res);
		$result->execute();
		for($i=0; $row = $result->fetch(); $i++){
	?>
    <option><?php echo $row['suplier_name']; ?></option>
    <?php
	}
	?>
  </select>
  </p>
<span>Категория : </span> 
<select name="catg" id="catg">
  <option value="ЖНВЛС">ЖНВЛС</option>
  <option value="Фиксированная">Фиксированная</option>
  <option value="Обычные">Обычные</option>
</select> 
<br>
  <span>Количество : </span>
  <input type="number" style="width:265px; height:30px;" min="0" id="txt11" onkeyup="sum();" name="qty" Required ><br>
  <span></span>
  <input type="hidden" style="width:265px; height:30px;" id="txt22" name="qty_sold" Required ><br>
</p>
<div style="float:right; margin-right:10px;">
  <button class="btn btn-success btn-block btn-large" style="width:267px;"><i class="icon icon-save icon-large"></i> Добавить</button>
</div>
</div>
</form>
