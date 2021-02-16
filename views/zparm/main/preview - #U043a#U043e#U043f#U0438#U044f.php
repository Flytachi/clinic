<?php require_once ('auth.php');?>
<!DOCTYPE html>
<html>
<head>
<title>Z-Pharma</title>
 <link href="css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
  
  <link rel="stylesheet" href="css/font-awesome.min.css">
    <style type="text/css">
    
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <style>
   @media print { /* Стиль для печати */
    body {
     font-family: Times, 'Times New Roman', serif; /*
	  Шрифт с засечками */
	      font-size: 250px; /* Размер шрифта в процентах */ 
    }
	table {
border-collapse: collapse; /*убираем пустые промежутки между ячейками*/
border: 1px solid grey; /*устанавливаем для таблицы внешнюю границу серого цвета толщиной 1px*/
}
table {width: 600px;}
th {width: 100%;}
td:first-child {width: 30%;}
    h1, h2, p {
     color: #000; /* Черный цвет текста */
    }
   }
   @page :first {
    margin: 1cm; /* Отступы для первой страницы */ 
   }
   @page :left {
    margin: 1cm 3cm 1cm 1.5cm; /* Отступы для всех левых страниц */ 
   }
   @page :right {
    margin: 1cm 3cm 1cm 1.5cm; /* Отступы для всех правых страниц */ 
   }
  </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script language="javascript">
function Clickheretoprint()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,width=450%, height=250%, left=100, top=25"; 
  var content_vlue = document.getElementById("content").innerHTML; 
  
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('</head><body onLoad="self.print()" style="width: 100%; font-size: 72px; font-family: arial;">');          
   docprint.document.write(content_vlue); 
   docprint.document.close(); 
   docprint.focus(); 
}
</script>
<?php
$invoice=$_GET['invoice'];
include('../connect.php');
$result = $db->prepare("SELECT * FROM sales WHERE invoice_number= :userid");
$result->bindParam(':userid', $invoice);
$result->execute();
for($i=0; $row = $result->fetch(); $i++){
$cname=$row['name'];
$invoice=$row['invoice_number'];
$date=$row['date'];
$cash=$row['due_date'];
$cashier=$row['cashier'];

$pt=$row['type'];
$am=$row['amount'];
if($pt=='cash'){
$cash=$row['due_date'];
$amount=$cash-$am;
}
}
?>
<?php
function createRandomPassword() {
	$chars = "003232303232023232023456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = '' ;
	while ($i <= 7) {

		$num = rand() % 33;

		$tmp = substr($chars, $num, 1);

		$pass = $pass . $tmp;

		$i++;

	}
	return $pass;
}
$finalcode='RS-'.createRandomPassword();
?>



 <script language="javascript" type="text/javascript">
/* Visit http://www.yaldex.com/ for full source code
and get more free JavaScript, CSS and DHTML scripts! */
<!-- Begin
var timerID = null;
var timerRunning = false;
function stopclock (){
if(timerRunning)
clearTimeout(timerID);
timerRunning = false;
}
function showtime () {
var now = new Date();
var hours = now.getHours();
var minutes = now.getMinutes();
var seconds = now.getSeconds()
var timeValue = "" + ((hours >12) ? hours -12 :hours)
if (timeValue == "0") timeValue = 12;
timeValue += ((minutes < 10) ? ":0" : ":") + minutes
timeValue += ((seconds < 10) ? ":0" : ":") + seconds
timeValue += (hours >= 12) ? " P.M." : " A.M."
document.clock.face.value = timeValue;
timerID = setTimeout("showtime()",1000);
timerRunning = true;
}
function startclock() {
stopclock();
showtime();
}
window.onload=startclock;
// End -->
</SCRIPT>
<body>

<?php include('navfixed.php');?>
	
	<div class="container-fluid">
      <div class="row-fluid">
	<div class="span2">
             <div class="well sidebar-nav">
                 <ul class="nav nav-list">
              <li><a href="index.php"><i class="icon-dashboard icon-2x"></i> Личный кабинет </a></li> 
			<li class="active"><a href="sales.php?id=cash&invoice"><i class="icon-shopping-cart icon-2x"></i> Продажы</a>  </li>             
			<li><a href="products.php"><i class="icon-list-alt icon-2x"></i> Препараты (товары)</a>                                     </li>
			<li><a href="customer.php"><i class="icon-group icon-2x"></i> Клиенты</a>                                    </li>
			<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Поставщики</a>                                    </li>
			<li><a href="salesreport.php?d1=0&d2=0"><i class="icon-bar-chart icon-2x"></i> Отчеты продаж</a>                </li>
			<li><a href="sales_inventory.php"><i class="icon-table icon-2x"></i> Инвентаризация продаж</a>                </li>
				<br><br><br><br><br><br>		
			<li>
			 <div class="hero-unit-clock">
		
			<form name="clock">
			<font color="white">Текущее время</font><font color="white">: <br></font>&nbsp;<input style="width:150px;" type="submit" class="trans" name="face" value="">
			</form>
			  </div>
			</li>
				
				</ul>           
          </div><!--/.well -->
        </div><!--/span-->
		
	<div class="span10">
	<a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><button class="btn btn-default"><i class="icon-arrow-left"></i> Назад в продажы</button></a>

<div class="content" id="content" >
<div style="margin: 0 auto; padding: 20px; width: 900px; font-weight: normal;" >
	
	  <div class ="print" id="print" style="width:50px;transform:rotate(-0deg);-moz-transform:rotate(-90deg);-webkit-transform:rotate(-0deg); margin-top:0px">
	    <table width="626%" height="37%" border="1" cellpadding="0" cellspacing="0" id="maintable" style="font-family: arial; font-size: 19px; text-align: center;">
	    <thead>
	      <tr>
	        <th height="41" colspan="4"><?php echo 'OOO BUXORO GIYOH FARM' ; ?><span style="text-align: center"></span></th>
	        </tr>
	      <tr>
	        <th height="57"> Название </th>
	        <th width="54">кол-во</th>
	        <th width="45">Цена </th>
	        <th width="42" nowrap="nowrap"> Всего </th>
	        </tr>
	      </thead>
	    <tbody>
	      <?php
					$id=$_GET['invoice'];
					$result = $db->prepare("SELECT * FROM sales_order WHERE invoice= :userid");
					$result->bindParam(':userid', $id);
					$result->execute();
					for($i=0; $row = $result->fetch(); $i++){
				?>
	      <tr class="record">
	        <td height="20"><?php echo $row['product_code']; ?></td>
	        <td><?php echo $row['qty']; ?></td>
	        <td><?php
				$ppp=$row['price'];
				echo formatMoney($ppp, true);
				?></td>
	        <td nowrap="nowrap"><?php
				$dfdf=$row['amount'];
				echo formatMoney($dfdf, true);
				?></td>
	        </tr>
	      <?php
					}
				?>
	      <tr>
	        <td height="23" colspan="3" style=" text-align:right;"><strong style="font-size: 19px;">Итог: &nbsp;</strong></td>
	        <td colspan="2" nowrap="nowrap"><strong style="font-size: 19px;">
	          <?php
					$sdsd=$_GET['invoice'];
					$resultas = $db->prepare("SELECT sum(amount) FROM sales_order WHERE invoice= :a");
					$resultas->bindParam(':a', $sdsd);
					$resultas->execute();
					for($i=0; $rowas = $resultas->fetch(); $i++){
					$fgfg=$rowas['sum(amount)'];
					echo formatMoney($fgfg, true);
					}
					?>
	          </strong></td>
	        </tr>
	      <tr>
	        <td height="22" colspan="5" style=" text-align:right;">Дата <?php echo $date ?>&nbsp&nbsp&nbsp
	          <?php date_default_timezone_set('Asia/Tashkent'); 
echo date( "H:i" );?>&nbsp&nbsp&nbsp№ чека. 
	          :
	          <?php
	$resulta = $db->prepare("SELECT * FROM customer WHERE customer_name= :a");
	$resulta->bindParam(':a', $cname);
	$resulta->execute();
	for($i=0; $rowa = $resulta->fetch(); $i++){
	$address=$rowa['address'];
	$contact=$rowa['contact'];
	}
	?>
	          <?php echo $invoice ?></td>
	        </tr>
	      <tr>
	        <td height="42" colspan="5" style="text-align: center;">Будьте здоровы !</td>
	        </tr>
	      <?php if($pt=='cash'){
				?>
	      <?php
				}
				?>
	      </tbody>
	    </table>
	    <center>
	      <div style="font:bold 25px 'Aleo';"></div>
	  <br>
	</center>
	<div></div>
	</div>
	<div class="clearfix"></div>
	</div>
	<div style="width: 100%; margin-top: -70px; text-align: left;">
	  <center></center>
	</div>
	</div>
	</div>
	</div>
<div class="pull-right" style="margin-right:100px;">
		<a href="javascript:Clickheretoprint()" style="font-size:20px;"><button class="btn btn-success btn-large"><i class="icon-print"></i> Распечатать чек</button></a>
		</div>
<strong style="font-size: 12px; color: #222222;">
<?php
					echo formatMoney($cash, true);
					?>
</strong><strong style="font-size: 15px; color: #222222;">
<?php
					function formatMoney($number, $fractional=false) {
						if ($fractional) {
							$number = sprintf('%.2f', $number);
						}
						while (true) {
							$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
							if ($replaced != $number) {
								$number = $replaced;
							} else {
								break;
							}
						}
						return $number;
					}
					if($pt=='credit'){
					echo $cash;
					}
					if($pt=='cash'){
					echo formatMoney($amount, true);
					}
					?>
</strong><span style=" text-align:right;"><strong style="font-size: 12px; color: #222222;">
<?php
					if($pt=='cash'){
					echo 'Due Date:';
					}
					if($pt=='credit'){
					echo 'Due Date:';
					}
					?>
</strong></span>      </div>
</div>


