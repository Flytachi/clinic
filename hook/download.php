<?php

use Mixin\Hell;

require_once '../tools/warframe.php';
$session->is_auth();

if ( isset($_GET['model']) ) {

    if (class_exists($_GET['model'])) {
        $form = new $_GET['model'];
        write_excel($form->table, $_GET['file'], $form->table_label, $_GET['is_null']);
    }else dd("Модель не найдена!");
    
}else Hell::error('403');

?>
