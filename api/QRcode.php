<?php
require_once '../tools/warframe.php';
require_once '../libs/QRcode/qrlib.php'; 

QRcode::png($_GET['url']);
?>