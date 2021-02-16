<?php 
require_once('auth.php');
error_reporting(E_ALL);
ini_set('display_errors',1);
?><html>
<head>
<title>Аптека управление</title>
<script type="text/javascript" src="jquery-3.2.0.js"></script>
 <link rel="stylesheet" href="footer/alertify.css">
 <link rel="stylesheet" href="footer/themes/default.css">
  <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
  
  <link rel="stylesheet" href="css/font-awesome.min.css">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
	  .semi-transparent-button {
  display: -webkit-inline-box;
  box-sizing: border-box;
  margin: 0 auto;
  padding: 8px;
  width: 100%;
  max-width: 200px;
  background: #fff; /* fallback color for old browsers */
  background: rgba(255, 255, 255, 0.5);
  border-radius: 8px;
  color: #fff;
  text-align: center;
  text-decoration: none;
  letter-spacing: 1px;
  transition: all 0.3s ease-out;
}
.semi-transparent-button:hover,
.semi-transparent-button:focus,
.semi-transparent-button:active {
  background: #fff;
  color: #000;
  transition: all 0.5s ease-in;
}
.semi-transparent:focus {
  outline: none;
}

.is-blue {
  background: #1e348e; /* fallback color for old browsers */
  background: rgba(30, 52, 142, 0.5);
}
.is-blue:hover,
.is-blue:focus,
.is-blue:active {
  background: #1e348e; /* fallback color for old browsers */
  background: rgb(30, 52, 142);
  color: #fff;
}

.with-border {
  border: 1px solid #fff;
}
.buttonss {
    display: flex;
    flex-wrap: wrap;
     justify-content: flex-start;
	 /*justify-content: space-around;*/
    align-items: center;
    align-content: center;
    border-radius: 5px;
	margin-top:15px ;
}
.blockk {
    width: 177px;
    height: 25px;    
    text-align: center;
    line-height: 25px;        
}
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<!--sa poip up-->
<script src="jeffartagame.js" type="text/javascript" charset="utf-8"></script>
<script src="js/application.js" type="text/javascript" charset="utf-8"></script>
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css">
.semi-transparent-button1 {  display: block;
  box-sizing: border-box;
  margin: 0 auto;
  padding: 8px;
  width: 80%;
  max-width: 200px;
  background: #fff; /* fallback color for old browsers */
  background: rgba(255, 255, 255, 0.5);
  border-radius: 8px;
  color: #fff;
  text-align: center;
  text-decoration: none;
  letter-spacing: 1px;
  transition: all 0.3s ease-out;
}
</style>
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('a[rel*=facebox]').facebox({
      loadingImage : 'src/loading.gif',
      closeImage   : 'src/closelabel.png'
    })
  })
</script>

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
<?php include('navfixed.php');?>
<div class="container-fluid">
<div class="row-fluid">
      
	<div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li><a href="index.php"><i class="icon-dashboard icon-2x"></i> Личный кабинет </a></li> 
			<li><a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><i class="icon-shopping-cart icon-2x"></i> Продажа</a>  </li>             
			<li class="active"><a href="products.php"><i class="icon-list-alt icon-2x"></i> Препараты (товары)</a>                                     </li>
			<li><a href="customer.php"><i class="icon-group icon-2x"></i> Клиенты</a>                                    </li>
			<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Поставщики</a>                                    </li>
			<li><a href="salesreport.php?d1=0&d2=0"><i class="icon-bar-chart icon-2x"></i> Отчет продаж</a>                </li>
            <li><a href="sales_inventory.php"><i class="icon-table icon-2x"></i> Инвентаризация продаж</a>                </li><li><a href="all_prep.php"><i class="icon-table icon-2x"></i> Все наименования</a>                </li>


			<br><br><br><br><br><br>		
			<li>
			 <div class="hero-unit-clock">
		
			<form name="clock">
			<font color="white">Текущее время: <br></font>&nbsp;<input style="width:150px;" type="submit" class="trans" name="face" value="">
			</form>
			  </div>
			</li>
				
			</ul>             
          </div><!--/.well -->
  </div><!--/span-->
	<div class="span10">
	<div class="contentheader">
			<i class="icon-table"></i>Препараты</div>
			<ul class="breadcrumb">
			<li><a href="index.php">Панель управления</a></li> /
			<li class="active">Препараты (товары)</li>
			</ul>


<div style="margin-top: -19px; margin-bottom: 21px;">

<a  href="index.php"><button class="btn btn-default btn-large" style="float: left;"><i class="icon icon-circle-arrow-left icon-large"></i> Назад</button></a>
			<?php 
			include('../connect.php');
				$result = $db->prepare("SELECT * FROM products ORDER BY qty_sold DESC");
				$result->execute();
				$rowcount = $result->rowcount();
			?>
			<?php 
			include('../connect.php');
				$result = $db->prepare("SELECT * FROM products where qty < 10 ORDER BY product_id DESC");
				$result->execute();
				$rowcount123 = $result->rowcount();
			?>
            <?php 
			include('../connect.php');
				$result = $db->prepare("SELECT `catg`, `qty` FROM `products` WHERE `catg` = 'ОЛСИМН' && `qty` < 10;");
				$result->execute();
				$rowcountjnvls = $result->rowcount();
			?>
            <?php 
			include('../connect.php');
				$result = $db->prepare("SELECT `catg`, `qty` FROM `products` WHERE `catg` = 'Фиксированная' && `qty` < 10;");
				$result->execute();
				$rowcountfixed = $result->rowcount();
			?>
            <?php 
			include('../connect.php');
			$d1 = strtotime('+120 days');
                $d2 = date('Y-m-d', $d1);
				$result = $db->prepare("SELECT * FROM products WHERE expiry_date BETWEEN :a AND :b ORDER by product_id DESC ");
				$result->bindParam(':a', $d1);
				$result->bindParam(':b', $d2);
				$result->execute();
				$rowcountexpd = $result->rowcount();
			?>
				<div style="text-align:center;">
			Количество вида препаратов:  <font color="green" style="font:bold 22px 'Aleo';">[<?php echo $rowcount;?>]</font>
			</div>
			<div style="text-align:center;">
			<font style="color:rgb(255, 95, 66);; font:bold 22px 'Aleo';">[<?php echo $rowcount123;?>]</font> Общее количество препаратов оставшиеся меньше 10 шт
			</div>
</div>


<input type="text" style="padding:15px;" name="filter" value="" id="filter" placeholder="Поиск..." autocomplete="off" />
<a rel="facebox" href="addproduct.php"><Button type="submit" class="btn btn-info" style="float:right; width:230px; height:35px;" /><i class="icon-plus-sign icon-large"></i> Приход </button></a><br><br>
</section>
    <div class="buttonss" position: absolute; width: 100%>
    <div class="blockk"><a rel="facebox" class="semi-transparent-button with-border" href="products_jnvls.php">ОЛСИМН<font style="color:#FF0000; font:bold 22px 'Aleo';">[<?php echo $rowcountjnvls;?>]</font></a></div>
    <div class="blockk"><a rel="facebox" class="semi-transparent-button with-border" href="products_price.php">ФИКС<font style="color:#FF0000; font:bold 22px 'Aleo';">[<?php echo $rowcountfixed;?>]</font></a></div>
    <div class="blockk"><a rel="facebox" class="semi-transparent-button with-border" href="products_expdate.php">ПО СРОКУ <font style="color:#FF0000; font:bold 22px 'Aleo';">[<?php echo $rowcountexpd;?>]</font></a></div>
    <div class="blockk"><a class="semi-transparent-button with-border" href="revision.php">ПЕЧАТЬ <font style="color:#FF0000; font:bold 22px 'Aleo';">[]</font></a></div>
</div>   
  
<table class="hoverTable" id="resultTable" data-responsive="table" style="text-align: left;">
  <thead>
		<tr>
			<th width="12%"> Название </th>
			<th width="14%"> Производитель </th>
			<th width="13%"> Серия </th>
			<th width="7%">Категория</th>
			<th width="9%">Поставщик</th>
			<th width="10%">Дата получения </th>
			<th width="6%">Срок годности</th>
			<th width="6%">Цена прихода</th>
			<th width="6%">Цена  продажи</th>
			<th width="5%">Кол-во</th>
			<th width="8%">Остаток</th>
			<th width="8%">Итого</th>
			<th width="8%">№ Сч/Факт</th>
			<th width="8%">Число.от</th>
			<th width="8%">Ед.изм</th>
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
				echo '<tr class="alert alert-warning record" style="color: #fff; background:#FF0000;">';
				}
				else {
				echo '<tr class="record">';
				}
			?>
		

		<td><?php echo $row['product_code']; ?></td>
			<td><?php echo $row['gen_name']; ?></td>
			<td><?php echo $row['product_name']; ?></td>
            			<td><?php echo $row['catg']; ?></td>

			  <td><?php echo $row['supplier']; ?></td>
			<td><?php echo $row['date_arrival']; ?></td>
			<td><?php echo $row['expiry_date']; ?></td>
			<td><?php
			$oprice=$row['o_price'];
			echo formatMoney($oprice, true);
			?></td>
			<td><?php
			$pprice=$row['price'];
			echo formatMoney($pprice, true);
			?></td>
			<td><?php echo $row['qty_sold']; ?></td>
			<td><?php echo $row['qty']; ?></td>
			<td>
			<?php
			$total=$row['total'];
			echo formatMoney($total, true);
			?>
			</td>
			<td><?php echo $row['fakturanumber']; ?></td>
			<td><?php echo $row['sdate']; ?></td>
			<td><?php echo $row['ediz']; ?></td>
            <td><?php echo $row['nnak']; ?></td>			
			<td><a rel="facebox" title="Редактировать" href="editproduct.php?id=<?php echo $row['product_id']; ?>"><button class="btn btn-warning"><i class="icon-edit"></i> </button> </a>
			<a href="#" id="<?php echo $row['product_id']; ?>" class="delbutton" title="Удалить"><button class="btn btn-danger"><i class="icon-trash"></i></button></a></td>
		</tr><?php
				}
			?>	<tr>
		  <td>ИТОГ : </td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><?php 

  
class Sample_class{

        private $db;

        public function __construct($database) {
            $this->db = $database;
        }   

        public function GetDistant($user_id,$status) {

                    $query = $this->db->prepare("SELECT SUM(qty_sold) FROM products");

                    $query->bindValue(1, $user_id);
                    $query->bindValue(2, $status);

                    try{ $query->execute();     

                     $rows =  $query->fetch();
                     return $rows[0];

              } catch (PDOException $e){die($e->getMessage());}  
            } 
    }

$dist = new Sample_class($db);

$user_id = 10;
$status = 2;

echo $dist->GetDistant($user_id,$status);
?></td>
		  <td><?php 

  
class Sampler_class{

        private $db;

        public function __construct($database) {
            $this->db = $database;
        }   

        public function GetDistant($user_id,$status) {

                    $query = $this->db->prepare("SELECT SUM(qty) FROM products");

                    $query->bindValue(1, $user_id);
                    $query->bindValue(2, $status);

                    try{ $query->execute();     

                     $rows =  $query->fetch();
                     return $rows[0];

              } catch (PDOException $e){die($e->getMessage());}  
            } 
    }

$dist = new Sampler_class($db);

$user_id = 10;
$status = 2;

echo $dist->GetDistant($user_id,$status);
?></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		
			
	</tbody>	
</</table>
<div class=" active-result"></div>
</div>
</div>
<p>&nbsp;</p>
<p>		
</p>
<script type="text/javascript">        
//override defaults
alertify.defaults.transition = "zoom";
alertify.defaults.theme.ok = "ui positive button";
alertify.defaults.theme.cancel = "ui black button";
</script> 
<script type="text/javascript">
$(function() {


$(".delbutton").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;
 if(confirm("Вы точно хотите удалить этот товар ? Если да намите ОК если нет ОТМЕНА"))
		  {

 $.ajax({
   type: "GET",
   url: "deleteproduct.php",
   data: info,
   success: function(){
   
   }
 });
         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		.animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
  </script><div class="targets-wrapper">


</body>
<?php include('footer.php');?>

</html>