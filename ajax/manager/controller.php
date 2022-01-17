<?php

use Mixin\HellCrud;

require_once '../../tools/warframe.php';
$session->is_auth();

if ($session->session_level == 1) {
    
    $value = (isset($_POST[0]['value'])) ? $_POST[0]['value'] : null;
    $query = HellCrud::insert_or_update("corp_constants", array('branch_id' => $_POST['branch_id'], 'const_label' => $_POST['module'], 'const_value' => $value), "const_label");
    echo 1;

}else {
    echo 'Доступ запрещён!';
}

?>
