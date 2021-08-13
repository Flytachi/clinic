<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

if ( isset($_POST) ) {

    foreach ($_POST as $key => $value) {

        if (in_array($key, ["constant_diet_time"])) {
            Mixin\insert_or_update("company_constants", array('const_label' => $key, 'const_value' => json_encode($value)), "const_label");
        }elseif (in_array($key, ["constant_throughput_ambulator_from", "constant_throughput_ambulator_before", "constant_throughput_stationar_from", "constant_throughput_stationar_before"])) {
            Mixin\insert_or_update("company_constants", array('const_label' => $key, 'const_value' => str_replace(',', '', $value)), "const_label");
        }else {
            Mixin\insert_or_update("company_constants", array('const_label' => $key, 'const_value' => $value), "const_label");
        }
        
    }

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
