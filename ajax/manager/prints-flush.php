<?php

use Mixin\HellCrud;

require_once '../../tools/warframe.php';
$session->is_auth(3);

if ( isset($_GET['flush']) and $_GET['flush'] == true ) {

    foreach (config("print", 1) as $key => $value) {
        if ( preg_match('/\blogotype\b/', $key) and preg_match('/\bstorage\b/', $value) ) {
            unlink($_SERVER['DOCUMENT_ROOT'].DIR.$value);
        }
        HellCrud::delete("company_constants", $key, "const_label");
    }
    $_SESSION['message'] .= '
    <div class="alert alert-primary" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
        Данные успешно очищены.
    </div>
    ';
    render();

}else {
    
    $_SESSION['message'] = '
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
        В доступе отказанно!
    </div>
    ';
    render();

}
?>