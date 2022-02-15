<?php
require_once '../tools/warframe.php';
require_once '../tools/libs/QRcode/qrlib.php'; 

QRcode::png($_GET['url']);
?>