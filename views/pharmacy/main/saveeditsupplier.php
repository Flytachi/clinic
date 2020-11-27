<?php
// configuration
include('../connect.php');

// new data
$id = $_POST['memi'];
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
$sql = "UPDATE supliers 
        SET suplier_name=?, suplier_address=?, suplier_contact=?, contact_person=?, note=? , rsh=?, bank=?, mf=?, inn=?
		WHERE suplier_id=?";
$q = $db->prepare($sql);
$q->execute(array($a,$b,$c,$d,$e,$rs,$bn,$mf,$in,$id));
header("location: supplier.php");

?>