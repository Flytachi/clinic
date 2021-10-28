<?php
require_once '../../tools/warframe.php';
$session->is_auth();

if ($session->session_level == "master") {
    
    if ($_GET['tb_name']) {
        Mixin\T_flush($_GET['tb_name']);
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }else {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> Ошибка обработки </span>
        </div>';
        render();
    }

}else {
    $_SESSION['message'] = '
    <div class="alert bg-danger alert-styled-left alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        <span class="font-weight-semibold"> Доступ запрещён! </span>
    </div>';
    render();
}
?>