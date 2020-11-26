<?php 
require_once('auth.php');
?><link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="savecustomer.php" method="post">
<center><h4><i class="icon-plus-sign icon-large"></i> Add Customer</h4></center>
<hr>
<div id="ac">
<span>Название : </span>
<input type="text" style="width:265px; height:30px;" name="name" placeholder="Full Name" Required/><br>
<span>Адрес : </span>
<input type="text" style="width:265px; height:30px;" name="address" placeholder="Address"/><br>
<span>Телефон : </span>
<input type="text" style="width:265px; height:30px;" name="contact" placeholder="Contact"/><br>
<span>Название товара: </span>
<textarea style="height:70px; width:265px;" name="prod_name"></textarea><br>
<span>Общая сумма: </span>
<input type="text" style="width:265px; height:30px;" name="memno" placeholder="Total"/><br>
<span>Заметки (р/с и т д...) : </span>
<textarea style="height:60px; width:265px;" name="note"></textarea><br>
<span>Дата поставки: </span>
<input type="date" style="width:265px; height:30px;" name="date" placeholder="Date"/><br>
<div style="float:right; margin-right:10px;">
<button class="btn btn-success btn-block btn-large" style="width:267px;"><i class="icon icon-save icon-large"></i> Добавить</button>
</div>
</div>
</form>