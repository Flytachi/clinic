<?php 
session_start();
include('../connect.php');
$nl = intval($_POST['nall']) ;
$a = $_POST['invoice'];
$b = $_POST['product'];
$c = intval($_POST['qty']);
   if($c > $nl) {
      echo "<div align='center'><font color='red' 
      style='font:bold 22px 'Aleo';'>Внимание Вы не сможете 
расходовать больше чем остаток. Сейчас будете перенаправлены' </font> 
</div><br> "; 
      echo "<meta http-equiv=\"refresh\" content=\"3;url=" . 
      $_SERVER['HTTP_REFERER'] . "\">";
   exit; 
}
$w = $_POST['pt'];
$date = $_POST['date'];
$discount = $_POST['discount'];
$result = $db->prepare("SELECT * FROM products WHERE product_id= :userid");
$result->bindParam(':userid', $b);
$result->execute();
for($i=0; $row = $result->fetch(); $i++){
$asasa=$row['price'];
$code=$row['product_code'];
$gen=$row['gen_name'];
$name=$row['product_name'];
$p=$row['profit'];
}

//edit qty
$sql = "UPDATE products 
        SET qty=qty-?
		WHERE product_id=?";
$q = $db->prepare($sql);
$q->execute(array($c,$b));
$fffffff=$asasa-$discount;
$d=$fffffff*$c;
$profit=$p*$c;
// query
$sql = "INSERT INTO sales_order (invoice,product,qty,amount,name,price,profit,product_code,gen_name,date) VALUES (:a,:b,:c,:d,:e,:f,:h,:i,:j,:k)";
$q = $db->prepare($sql);
$q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c,':d'=>$d,':e'=>$name,':f'=>$asasa,':h'=>$profit,':i'=>$code,':j'=>$gen,':k'=>$date));
header("location: sales.php?id=$w&invoice=$a");


?>