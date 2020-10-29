<?php
require_once '../tools/warframe.php';
is_auth();
delete($_GET['id'], $_GET['table'], $_GET['location'], 1);
?>