<?php
require_once '../../tools/warframe.php';
is_auth('master');

if ($_GET['file']) {
    echo exec("mysql -u clinic -pclin_pik27 clinic < ../../dump/".$_GET['file']);
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
        <span class="font-weight-semibold"> Ошибка статуса </span>
    </div>';
    render();
}
?>
