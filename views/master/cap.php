<?php
require_once '../../tools/warframe.php';
is_auth('master');

if ($_GET['is_delete']) {
    unlink("../../dump/".$_GET['file']);
    $_SESSION['message'] = '
    <div class="alert alert-primary" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
        Дамп успешно удалён!
    </div>
    ';
    render();
}elseif ($_GET['file']) {
    exec("mysqldump -u {$ini['DATABASE']['USER']} -p{$ini['DATABASE']['PASS']} {$ini['DATABASE']['NAME']} > ../../dump/original_base_".date("Y-m-d_H-i-s").".sql");
    exec("mysql -u {$ini['DATABASE']['USER']} -p{$ini['DATABASE']['PASS']} {$ini['DATABASE']['NAME']} < ../../dump/".$_GET['file']);
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
