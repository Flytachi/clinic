<?php
require_once '../tools/warframe.php';
$session->is_auth();
VisitSaleModel::form($_GET['pk']);
?>