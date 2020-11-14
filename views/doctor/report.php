<?php
require_once '../../tools/warframe.php';
is_auth();

if ($_GET['id']) {
    $pack = $db->query('SELECT report FROM visit_service WHERE id='.$_GET['id'])->fetch();
    echo $pack['report'];
}
?>
