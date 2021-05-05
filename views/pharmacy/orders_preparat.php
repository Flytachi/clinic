<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
is_module('module_pharmacy');
(new StorageHomeModel)->form_order($_GET['pk']);
?>
