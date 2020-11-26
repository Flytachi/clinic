<?php
session_start();
include('../connect.php');
$a = $_POST['name'];
$b = $_POST['address'];
$c = $_POST['contact'];
$d = $_POST['cperson'];
$e = $_POST['note'];
$rs = $_POST['rsh'];
$bn = $_POST['bank'];
$mf = $_POST['mfo'];
$in = $_POST['inn'];
// query
$sql = "INSERT INTO supliers (suplier_name,suplier_address,suplier_contact,contact_person,note,rsh,bank,mf,inn) VALUES (:a,:b,:c,:d,:e,:rs,:bn,:mf,:in)";
$q = $db->prepare($sql);
$q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c,':d'=>$d,':e'=>$e,':rs'=>$rs,':bn'=>$bn,':mf'=>$mf,':in'=>$in));
header("location: supplier.php");


?>