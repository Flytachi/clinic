<?php
require_once '../tools/warframe.php';
is_auth();
VisitSaleModel::form($_GET['pk']);
?>