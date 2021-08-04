<?php
require_once '../tools/warframe.php';
$session->is_auth();

foreach ($_POST as $key => $value) {
    Mixin\insert_or_update("company_constants", array('const_label' => $key, 'const_value' => $value), "const_label");
}
echo 1;
?>
