<?php
require_once '../tools/warframe.php';
is_auth();
if ($_GET['id']) {
    UserForm(0, $_GET['id']);
}else{
    UserForm(1, $_POST['id']);
}
?>