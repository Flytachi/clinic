<?php

use Mixin\HellCrud;

require_once '../tools/warframe.php';
$session->is_auth();

foreach ($_POST as $key => $value) HellCrud::insert_or_update("corp_constants", array('const_label' => $key, 'const_value' => $value), "const_label");
echo 1;
?>
