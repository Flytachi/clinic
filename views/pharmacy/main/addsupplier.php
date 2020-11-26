<?php
	require_once('auth.php');
?><link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="savesupplier.php" method="post">
<center><h4><i class="icon-plus-sign icon-large"></i> Новый поставщик</h4></center>
<hr>
<div id="ac">
<span>Название поставщика	 : </span>
<input type="text" style="width:265px; height:30px;" name="name" required/><br>
<span>Адрес : </span>
<input type="text" style="width:265px; height:30px;" name="address" /><br>
<span>Контактное лицо : </span>
<input name="cperson" type="text" id="cperson" style="width:265px; height:30px;" /><br>
<span>Телефон. : </span>
<input type="text" style="width:265px; height:30px;" name="contact" /><br>
<span>Р/с : </span>
<input name="rsh" type="text" id="rsh" style="width:265px; height:30px;" /><br>
<span>Банк: </span>
<input name="bank" type="text" id="bank" style="width:265px; height:30px;" /><br>
<span>МФО : </span>
<input name="mfo" type="text" id="mfo" style="width:265px; height:30px;" /><br>
<span>ИНН : </span>
<input name="inn" type="text" id="inn" style="width:265px; height:30px;" /><br>
<span>Заметки : </span>
<textarea style="width:265px; height:80px;" name="note" /></textarea><br>
<div style="float:right; margin-right:10px;">
<button class="btn btn-success btn-block btn-large" style="width:267px;"><i class="icon icon-save icon-large"></i> Добавить</button>
</div>
</div>
</form>