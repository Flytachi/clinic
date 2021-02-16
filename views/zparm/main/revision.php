<?php 
require_once('auth.php');
?><html>
<head>
<title>Аптека управление</title>
</head>
<?php 
if ($_SESSION['SESS_FIRST_NAME']== 'Kassir') {?>
<div align="center"><font color="red" style="font:bold 22px 'Aleo';"> "Ошибка запроса.Подождите сейчас будете перенаправлены"</font> </div><br><?php echo "<meta http-equiv=\"refresh\" content=\"3;url=" . $_SERVER['HTTP_REFERER'] . "\">";
?>
		<?php exit () ;
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

<script>
function sum() {
            var txtFirstNumberValue = document.getElementById('txt1').value;
            var txtSecondNumberValue = document.getElementById('txt2').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt3').value = result;
				
            }
			
			 var txtFirstNumberValue = document.getElementById('txt11').value;
            var result = parseInt(txtFirstNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt22').value = result;				
            }
			
			 var txtFirstNumberValue = document.getElementById('txt11').value;
            var txtSecondNumberValue = document.getElementById('txt33').value;
            var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt55').value = result;
				
            }
			
			 var txtFirstNumberValue = document.getElementById('txt4').value;
			 var result = parseInt(txtFirstNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt5').value = result;
				}
			
        }
</script>


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
<script type="text/javascript">
      window.onload = function() { window.print(); }
 </script>
<div class="container-fluid">
<div class="row-fluid"><!--/span-->
	<div class="span10">
	  <div class="buttonss" position: absolute; width: 100%>
	    <div class="blockk" style="text-align: center"><strong>Остаток лекарственных препаратов  на 
        <?php date_default_timezone_set('Asia/Tashkent'); 

echo date("d/m/Y"); 
?>
        </strong></div>
	    <div class="blockk"></div>
</div>   
  
<table width="1111" border="1" cellpadding="0" class="hoverTable" id="resultTable" style="text-align: left;" data-responsive="table">
  <thead>
		<tr>
			<th width="9%" style="text-align: center">Наименоние</th>
			<th width="11%" style="text-align: center"> Производитель </th>
			<th width="5%" style="text-align: center"> Серия </th>
			<th width="7%" style="text-align: center">Категория</th>
			<th width="8%" style="text-align: center">Поставщик</th>
			<th width="8%" style="text-align: center">Дата получения </th>
			<th width="6%" style="text-align: center">Срок годности</th>
			<th width="6%" style="text-align: center">Цена прихода</th>
			<th width="6%" style="text-align: center">Цена  продажи</th>
			<th width="4%" style="text-align: center">Кол-во</th>
			<th width="6%" style="text-align: center">Остаток</th>
			<th width="4%" style="text-align: center">Итого</th>
			<th width="6%" style="text-align: center">№ Сч/Факт</th>
			<th width="6%" style="text-align: center">Число.от</th>
			<th width="6%" style="text-align: center">Ед.изм</th>
		</tr>
	</thead>
	<tbody>
		
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
				}?>
				<?php include('../connect.php');
				
				$result = $db->prepare("SELECT *, price * qty as total FROM products ORDER BY product_id DESC");
				$result->execute();
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$total=$row['total'];
				$availableqty=$row['qty'];
				if ($availableqty < 10) {
				echo '<tr class="" style="color: #000000; background:#аааааа;">';
				}
				else {
				echo '<tr class="record">';
				}
			?>
		

		<td style="text-align: center"><?php echo $row['product_code']; ?></td>
			<td style="text-align: center"><?php echo $row['gen_name']; ?></td>
			<td style="text-align: center"><?php echo $row['product_name']; ?></td>
            			<td style="text-align: center"><?php echo $row['catg']; ?></td>

			  <td style="text-align: center"><?php echo $row['supplier']; ?></td>
			<td style="text-align: center"><?php echo $row['date_arrival']; ?></td>
			<td style="text-align: center"><?php echo $row['expiry_date']; ?></td>
			<td style="text-align: center"><?php
			$oprice=$row['o_price'];
			echo formatMoney($oprice, true);
			?></td>
			<td style="text-align: center"><?php
			$pprice=$row['price'];
			echo formatMoney($pprice, true);
			?></td>
			<td style="text-align: center"><?php echo $row['qty_sold']; ?></td>
			<td style="text-align: center"><?php echo $row['qty']; ?></td>
			<td style="text-align: center">
			<?php
			$total=$row['total'];
			echo formatMoney($total, true);
			?>
			</td>
			<td style="text-align: center"><?php echo $row['fakturanumber']; ?></td>
			<td style="text-align: center"><?php echo $row['sdate']; ?></td>
			<td style="text-align: center"><?php echo $row['ediz']; ?></td>
            <td width="2%"><?php echo $row['nnak']; ?></td>			
			<td width="0%">
			</td>
		</tr><?php
				}
			?>	
			
	</tbody>	
</</table>
<div class=" active-result"></div>
</div>
</div>
<p>&nbsp;</p>
<p>		
</p>
<div class="targets-wrapper">
<script language = 'javascript'>
  var delay = 0;
  setTimeout("document.location.href='products.php'", delay);
</script>

</body>
<?php include('footer.php');?>

</html>