<?php
require_once '../tools/warframe.php';
$session->is_auth();
(new VisitSaleModel)->form($_GET['pk']);
?>