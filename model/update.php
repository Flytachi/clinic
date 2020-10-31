<?php
require_once '../tools/warframe.php';
is_auth();
if ($_GET['id']) {
    $_GET['form'](0, $_GET['id']);
}else{
    $_POST['form_name'](1, $_POST['id']);
}
?>