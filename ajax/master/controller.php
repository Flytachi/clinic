<?php
require_once '../../tools/warframe.php';
$session->is_auth();

if ($session->session_level == "master") {
    
    $query = Mixin\insert_or_update("company_constants", array('const_label' => $_POST['module'], 'const_value' => $_POST[0]['value']), "const_label");
    echo 1;

}else {
    echo 'Доступ запрещён!';
}

?>
