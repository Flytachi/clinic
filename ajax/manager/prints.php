<?php
require_once '../../tools/warframe.php';
$session->is_auth(3);

if ( isset($_POST) ) {

    Mixin\insert_or_update("corp_constants", array('const_label' => "constant_print_document_qrcode", 'const_value' => null), "const_label");
    
    for ($s=1; $s <= $print_hr_count; $s++) { 
        Mixin\insert_or_update("corp_constants", array('const_label' => "constant_print_document_hr-$s", 'const_value' => null), "const_label");
    }

    for ($i=1; $i <= config('print_document_blocks'); $i++) { 

        Mixin\insert_or_update("corp_constants", array('const_label' => "constant_print_document_$i-type", 'const_value' => null), "const_label");
        Mixin\insert_or_update("corp_constants", array('const_label' => "constant_print_document_$i-logotype-is_circle", 'const_value' => null), "const_label"); 
        
        for ($t=1; $t <= $print_text_count; $t++) {
            Mixin\insert_or_update("corp_constants", array('const_label' => "constant_print_document_$i-text-$t-is_bold", 'const_value' => null), "const_label");
        }

    }

    foreach ($_POST as $key => $value) {

        Mixin\insert_or_update("corp_constants", array('const_label' => $key, 'const_value' => $value), "const_label");
        
    }

    include 'download_logo.php';

    $_SESSION['message'] .= '
    <div class="alert alert-primary" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
        Данные внесены.
    </div>
    ';

    render();

}else {
    
    $_SESSION['message'] = '
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
        Нет данных!
    </div>
    ';

    render();

}
?>
