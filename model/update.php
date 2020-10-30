<?php
require_once '../tools/warframe.php';
is_auth();
if ($_GET['id']) {
    $_SESSION['form_name'](0, $_GET['id']);
}else{
    $_SESSION['form_name'](1, $_POST['id']);
}
?>