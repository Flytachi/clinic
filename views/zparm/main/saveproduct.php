<?php
	require_once('auth.php');
?><?php
session_start();

include('../connect.php');
$a = $_POST['code'];
$b = $_POST['name'];
$c = $_POST['exdate'];
$d = $_POST['price'];
$e = $_POST['supplier'];
$ct = $_POST['catg'] ;
$f = $_POST['qty'];
$g = $_POST['o_price'];
$h = $_POST['profit'];
$i = $_POST['gen'];
$j = $_POST['date_arrival'];
$k = $_POST['qty_sold'];
$sd = $_POST['sdate'] ;
$edz = $_POST['ediz'] ;
$faktnumber = $_POST['fakturanumber'] ;
$qtyupp = $_POST['qtyup'] ;
$shco = $_POST['shcode'] ;
$nn = $_POST['naklnum'] ;
// query
$sql = "INSERT INTO products (product_code,product_name,expiry_date,price,supplier, catg,qty,o_price,profit,gen_name,date_arrival,qty_sold,sdate,ediz, fakturanumber, qtyu,shcod,nnak) VALUES (:a,:b,:c,:d,:e,:ct,:f,:g,:h,:i,:j,:k,:sd,:edz,:faktnumber,:qtyupp,:shco,:nn)";
$q = $db->prepare($sql);
$q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c,':d'=>$d,':e'=>$e,':ct'=>$ct,':f'=>$f,':g'=>$g,':h'=>$h,':i'=>$i,':j'=>$j,':k'=>$k,':sd'=>$sd,
				':edz'=>$edz,':faktnumber'=>$faktnumber,':qtyupp'=>$qtyupp,':shco'=>$shco,':nn'=>$nn));
header("location: products.php");

?>
