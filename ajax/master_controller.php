<?php
require_once '../tools/warframe.php';
is_auth();

// prit($_POST);
$query = Mixin\insert_or_update("company", array('const_label' => $_POST['module'], 'const_value' => $_POST[0]['value']), "const_label");
echo 1;
?>
