<?php 
	require_once('auth.php');
?>
<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="vendors/chosen.min.css">

<table width="950" border="0">
  <tr>
    <td><form action="saveproduct.php" method="post">
<center>
  <h4><i class="icon-plus-sign icon-large"></i> Приходный лист</h4>
  <table width="956" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td height="35" style="text-align: left">Наименование</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><select name="code" required class="chzn-select"   style="width:100%;  ">
        <option></option>
        <?php
	include('../connect.php');
	$result = $db->prepare("SELECT * FROM goods");
		$result->bindParam(':userid', $res);
		$result->execute();
		for($i=0; $row = $result->fetch(); $i++){
	?>
        <option><?php echo $row['goodname']; ?></option>
        <?php
	}
	?>
      </select></td>
      <td style="text-align: justify"><a href="newpr.php"><img src="img/Button-Add-icon.png" width="22" height="21"  alt="Добавить новый препарат если нету в базе"/></a></td>
    </tr>
    <tr>
      <td width="111" height="35" style="text-align: left">Поставщик</td>
      <td width="1" height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><select name="supplier" style="width:100%;  height:30px; "class="chzn-select" required>
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
      </select></td>
      <td width="27" style="text-align: justify"><a href="supplier.php"><img src="img/Button-Add-icon.png" width="22" height="21"  alt="Добавить поставщика если нету в базе"/></a></td>
    </tr>
    <tr>
      <td height="35" style="text-align: left">Счет фактура №</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="4" style="text-align: justify"><input name="fakturanumber"  type="text" id="fakturanumber" style="width:100%; height:30px;" required />        <br></td>
      <td width="68" style="text-align: center">От </td>
      <td width="269" style="text-align: justify"><input Required name="sdate" type="date" id="sdate" style="width:265px; height:30px;" /></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    
    <tr>
      <td height="35" style="text-align: left">Количество</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td width="74" height="35" valign="middle" style="text-align: justify; font-size: small;"><strong>Целая.УП</strong></td>
      <td width="146" valign="middle" style="text-align: justify"><input name="qtyup" type="text" value="" required id="upak" style="width:100%; height:30px;"  oninput="mult()"></td>
      <td width="86" valign="middle" style="text-align: justify; font-size: small;"><strong>Шт.остаток</strong></td>
      <td width="146" style="text-align: justify"><input name="ostunit" type="text" value="" required id="unit" style="width:100%; height:30px;"  ></td>
      <td height="35" valign="top" style="text-align: justify; font-size: small;"><strong>Таб.в упаковке (шт)</strong></td>
      <td height="35" style="text-align: justify"><input name="qtyvup" type="text"  required id="vupak" style="width:100%; height:35px;" value="" oninput="mult()"></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    <tr>
      <td height="35" style="text-align: left">Производитель</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><input type="text" style="width:550px; height:30px;" name="gen" required/></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    <tr>
      <td height="35" style="text-align: left">Ед.изм</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><select name="ediz"class="chzn-select" id="ediz">
        <option value="УП">УП</option>
        <option value="ПРТ">ПРТ</option>
        <option value="ШТ">ШТ</option>
        <option value="ОРГ">ОРГ</option>
        <option value="КВТ">КВТ</option>
        <option value="ФЛ">ФЛ</option>
      </select></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    <tr>
      <td height="35" style="text-align: left">Количество</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><input style="width:100%; height:30px;" min="0" id="txt11" name="qty" readonly  required></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    <tr>
      <td height="35" style="text-align: left">Цена прихода одной упаковки</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><input name="prixodup" type="text"" required id="prixodup" style="width:100%; height:30px;"  oninput="delenie()"></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    <tr>
      <td height="35" style="text-align: left"> Реальная цена одной таблетки </td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><input type="text" id="txt2"  style="width:100%; height:30px;" name="o_price"  onKeyUp="sum();" readonly required></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
	<tr>
      <td height="35" style="text-align: left"> Процент продаж </td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><input type="text" id="prc"  style="width:100%; height:30px;" name="prc"    required onKeyUp="percentit();"></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    <tr>
      <td height="35" style="text-align: left">Цена продажи</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><input type="text" id="txt1" style="width:100%; height:30px;" name="price" onKeyUp="sum();" required></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
	
    <tr>
      <td height="35" style="text-align: left">Прибыль</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><input type="text" id="txt3" style="width:100%; height:30px;" name="profit" readonly></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    <tr>
      <td height="35" style="text-align: left">Категория </td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify">
	  <input type="hidden" style="width:265px; height:30px;" id="catg" name="catg" value="Обычные" Required >
	  </td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    <tr>
      <td height="35" style="text-align: left">Дата получения</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><input type="date" required style="width:265px; height:30px;" name="date_arrival" />
        Накладная № <input type="text" Required style="width:265px; height:30px;" name="naklnum" /></td>
        
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    <tr>
      <td height="35" style="text-align: left">Срок годности</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><input type="date" required value="<?php echo date ('M-d-Y'); ?>" style="width:265px; height:30px;" name="exdate" /></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    <tr>
      <td height="35" style="text-align: left">Серия</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><input name="name"  type="text" id="name" style="width:100%; height:30px;" required /></td><tr>
      <td height="35" style="text-align: left">Штрих код</td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"><input name="shcode"  type="text" id="shcode" style="width:100%; height:30px;" required /></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    <tr>
      <td height="35" style="text-align: left"><input type="hidden" style="width:265px; height:30px;" id="txt22" name="qty_sold" Required ></td>
      <td height="35" style="text-align: justify">&nbsp;</td>
      <td height="35" colspan="6" style="text-align: justify"></td>
      <td style="text-align: justify">&nbsp;</td>
    </tr>
    </table>
</center>
<div id="ac">

  <script> 
function mult() {
    var vupak = document.getElementById('vupak').value;
    var upak = document.getElementById('upak').value;
    var unt = document.getElementById('unit').value;

    document.getElementById('txt11').value = upak * vupak + +unt;
} 
  </script>
   <script> 
function delenie() {
    var vupak1 = document.getElementById('prixodup').value;
    var unitt = document.getElementById('vupak').value;
    var upak1 = document.getElementById('txt11').value;
    document.getElementById('txt2').value = vupak1/unitt;
} 
   </script>
   <script> 
function percentit() {
    var prc2 = document.getElementById('prc').value;
    var txt23 = document.getElementById('txt2').value;
    var o_price1 = document.getElementById('txt2').value;
	
    document.getElementById('txt1').value = (prc2/100)*txt23 + +o_price1;
} 
  </script>
<div style="float:right; margin-right:10px;">
  <button class="btn btn-success btn-block btn-large" style="width:267px;"><i class="icon icon-save icon-large"></i> Добавить</button>
  
</div>
</div>
</form>
<script src="vendors/jquery.js" type="text/javascript"></script>
<br><script src="vendors/chosen.jquery.min.js" type="text/javascript"></script>
<br><script>
$(".chzn-select").chosen({
    search_contains: true,
    no_results_text: "Нету совпадений",
	placeholder_text_single: "Введите название",
    width: "100%"
	
  });
  </script></td>
  </tr>
</table>
