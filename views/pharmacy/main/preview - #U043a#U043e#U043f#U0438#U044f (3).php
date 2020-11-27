<?php require_once ('auth.php');?>
<!DOCTYPE html>
<html>
<head>
<title>Z-Pharma</title>

    <style>
   @media print { /* Стиль для печати */
    body {
     font-family: Times, 'Times New Roman', serif; /*
	  Шрифт с засечками */
	      font-size: 19px; /* Размер шрифта в процентах */ 
    }
	table {
border-collapse: collapse; /*убираем пустые промежутки между ячейками*/
border: 1px solid grey; /*устанавливаем для таблицы внешнюю границу серого цвета толщиной 1px*/

}
table {width: 100px;}
    h1, h2, p {
     color: #000; /* Черный цвет текста */
    }
	.col1 {
    width: 258px; /* Ширина ячейки */
   }
   }  </style>
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
?></head>
<body>
<script type="text/javascript">
      window.onload = function() { window.print(); }
 </script>
<table width="858px" height="10%" border="0" cellpadding="0" cellspacing="0" id="filter" style="font-family: arial; font-size: 19px; text-align: center;">
	    <thead>
	      <tr id="resultTable">
	        <th height="29" colspan="4"><?php echo 'OOO BUXORO GIYOH FARM' ; ?><span style="text-align: center"></span></th>
	        </tr>
	      <tr>
	        <th width="483" height="50" id="resultTable" > Название </th>
	        <th width="76"><p>кол-во</p></th>
	        <th width="121">Цена </th>
	        <th width="168" nowrap="nowrap"> Всего </th>
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
	        <td height="67" align="center" valign="middle" id="resultTable"><strong><?php echo $row['product_code']; ?></strong>
            </td>
	        <td><strong><?php echo $row['qty']; ?></strong></td>
	        <td><strong><?php
				$ppp=$row['price'];
				echo formatMoney($ppp, true);
				?>
            </strong></td>
	        <td nowrap="nowrap"><strong><?php
				$dfdf=$row['amount'];
				echo formatMoney($dfdf, true);
				?></strong></td>
          </tr>
	      <?php
					}
				?>
	      <tr>
	        <td height="15" id="resultTable" style=" text-align:right;"><strong style="font-size: 19px;">Итог: &nbsp;</strong></td>
	        <td height="15" id="resultTable" style=" text-align:right;">&nbsp;</td>
	        <td height="15" id="resultTable" style=" text-align:right;">&nbsp;</td>
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
	        <td height="30" colspan="2" valign="top" id="resultTable" style="text-align: left;"><p><strong>Дата <?php echo $date ?>&nbsp&nbsp&nbsp Время:
  <?php date_default_timezone_set('Asia/Tashkent'); 
echo date( "H:i" );?>
            </strong></p></td>
	        <td height="30" colspan="3" valign="middle" id="resultTable" style="text-align: left;"><strong>№ чека
                  <?php
	$resulta = $db->prepare("SELECT * FROM customer WHERE customer_name= :a");
	$resulta->bindParam(':a', $cname);
	$resulta->execute();
	for($i=0; $rowa = $resulta->fetch(); $i++){
	$address=$rowa['address'];
	$contact=$rowa['contact'];
	}
	?>
             <?php echo $invoice ?></strong></td>
          </tr>
	      <tr id="resultTable">
	        <td height="15" colspan="5" style="text-align: center;"><strong>Будьте здоровы !</strong></td>
          </tr>
	      <?php if($pt=='cash'){
				?>
	      <?php
				}
				?>
	      </tbody>
	    </table>
	    
	<div class="clearfix"></div>
	</div>
	<div style="width: 100%; margin-top: -70px; text-align: left;">
	  <center></center>
	</div>
	</div>
	</div>
	</div>
<strong style="font-size: 12px; color: #222222;">
<?php
					//echo formatMoney($cash, true);
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
					//echo $cash;
					}
					if($pt=='cash'){
					//echo formatMoney($amount, true);
					}
					?>
</strong><span style=" text-align:right;"><strong style="font-size: 12px; color: #222222;">
<?php
					//if($pt=='cash'){
					//echo 'Due Date:';
					//}
					//if($pt=='credit'){
					//echo 'Due Date:';
					//}
					?>
</strong></span>      </div>
</div>
<!--<script language = 'javascript'>
  var delay = 0;
  setTimeout("document.location.href='products.php'", delay);
</script>-->
</body>
</html>



